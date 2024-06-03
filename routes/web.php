<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
    //return view('welcome');
//});

Route::get('/', function () {
    return view('front');
})->name('frontpage');

Route::get('/record', [VideoController::class, 'index'])->name('record');
Route::post('/upload', [VideoController::class, 'upload'])->name('upload');
Route::get('/my-videos', [VideoController::class, 'myVideos'])->name('my-videos')->middleware('auth');
Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.delete')->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
