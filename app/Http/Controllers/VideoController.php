<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        return view('record');
    }

    public function upload(Request $request)
    {
        // Validate the request to ensure a video file is provided
        $request->validate([
            'video' => 'required|mimes:webm|max:10240', // Max size 10MB
        ]);

        // Check if a video file is uploaded
        if ($request->hasFile('video')) {
            // Store the video file in the 'videos' directory within the 'public' disk
            $path = $request->file('video')->store('videos', 'public');

            // Check if the user is authenticated
            if (Auth::check()) {
                // Create a new Video instance and save the video details to the database
                $video = new Video();
                $video->user_id = Auth::id(); // Associate the video with the authenticated user
                $video->path = $path; // Store the path of the video
                $video->name = $request->input('name', 'Untitled'); // Save the name from the input field or use 'Untitled' if not provided
                $video->save();
            }

            // Return a JSON response with the path of the uploaded video
            return response()->json(['path' => $path], 200);
        }

        // Return a JSON response with an error message if no video file is uploaded
        return response()->json(['error' => 'No video file uploaded'], 400);
    }

    public function myVideos()
    {
        $videos = Auth::user()->videos; // Assuming a User hasMany Videos relationship
        return view('my-videos', compact('videos'));
    }

    public function destroy(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            return redirect()->route('my-videos')->withErrors('You do not have permission to delete this video.');
        }

        Storage::disk('public')->delete($video->path);
        $video->delete();

        return redirect()->route('my-videos')->with('status', 'Video deleted successfully.');
    }
}
