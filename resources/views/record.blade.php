<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Recorder</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }

        #camera-video {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 200px;
            height: 150px;
            border: 2px solid white;
        }

        #timer {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 16px;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .button-group button,
        .button-group a {
            margin: 5px;
        }
        .pip-position-label {
            margin-right: 20px;
        }
    </style>
</head>

<body class="bg-green-100 flex items-center justify-center h-screen">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md text-center">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Video Recorder</h1>
        <div class="button-group mb-6" style="display: flex; justify-content: center;">
            <button id="record-camera" class="bg-blue-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-blue-600 focus:outline-none">Record Camera</button>
            <button id="record-screen" class="bg-green-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-green-600 focus:outline-none">Record Screen</button>
            <button id="record-both" class="bg-purple-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-purple-600 focus:outline-none">Record Both</button>
        </div>
        <span id="pip-label" class="mx-2 pip-position-label hidden">Choose Position:</span>
        <div class="button-group mb-6" style="display: flex; justify-content: center;">

            <button id="pip-top-left" class="bg-yellow-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-yellow-600 focus:outline-none hidden">Top Left</button>
            <button id="pip-bottom-left" class="bg-yellow-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-yellow-600 focus:outline-none hidden">Bottom Left</button>
            <button id="pip-top-right" class="bg-yellow-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-yellow-600 focus:outline-none hidden">Top Right</button>
            <button id="pip-bottom-right" class="bg-yellow-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-yellow-600 focus:outline-none hidden">Bottom Right</button>
        </div>
        <div id="record-container" class="mb-6 hidden relative">
            <video id="screen-video" width="640" height="480" autoplay muted
                class="border-2 border-gray-300 rounded-lg"></video>
            <video id="camera-video" autoplay muted class="rounded-lg"></video>
            <div id="timer" class="hidden">00:00:00</div>
            <div class="button-group mt-4">
                <button id="record"
                    class="bg-blue-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-blue-600 focus:outline-none">Start
                    Recording</button>
                <button id="pause"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-yellow-600 focus:outline-none hidden">Pause
                    Recording</button>
            </div>
        </div>
        <div id="playback-container" class="hidden mb-6">
            <video id="playback" width="640" height="480" controls
                class="border-2 border-gray-300 rounded-lg"></video>
            <div class="button-group mt-4">
                <a id="download"
                    class="bg-green-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-green-600 focus:outline-none">Download
                    Video</a>
                <button id="delete"
                    class="bg-red-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-red-600 focus:outline-none">Delete</button>
                <button id="record-again"
                    class="bg-blue-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-blue-600 focus:outline-none">Record
                    Again</button>
            </div>
            <div class="button-group mt-4">
                @auth
                    <button id="save"
                        class="bg-green-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-green-600 focus:outline-none">Save
                        Video</button>
                    <a href="{{ route('my-videos') }}">
                        <button
                            class="bg-green-500 text-white px-4 py-2 rounded-full transition duration-300 ease-in-out hover:bg-green-600 focus:outline-none">My
                            Videos</button>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <script>
        const screenVideo = document.getElementById('screen-video');
        const cameraVideo = document.getElementById('camera-video');
        const playback = document.getElementById('playback');
        const recordButton = document.getElementById('record');
        const pauseButton = document.getElementById('pause');
        const saveButton = document.getElementById('save');
        const downloadButton = document.getElementById('download');
        const deleteButton = document.getElementById('delete');
        const recordAgainButton = document.getElementById('record-again');
        const recordContainer = document.getElementById('record-container');
        const playbackContainer = document.getElementById('playback-container');
        const timer = document.getElementById('timer');

        const recordCameraButton = document.getElementById('record-camera');
        const recordScreenButton = document.getElementById('record-screen');
        const recordBothButton = document.getElementById('record-both');
        const pipLabel = document.getElementById('pip-label');

        let mediaRecorder;
        let recordedBlobs = [];
        let isRecording = false;
        let isPaused = false;
        let screenStream = null;
        let cameraStream = null;
        let startTime;
        let timerInterval;

        function startTimer() {
            startTime = Date.now();
            timerInterval = setInterval(() => {
                const elapsedTime = Date.now() - startTime;
                const hours = Math.floor(elapsedTime / 3600000);
                const minutes = Math.floor((elapsedTime % 3600000) / 60000);
                const seconds = Math.floor((elapsedTime % 60000) / 1000);
                timer.textContent =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function stopTimer() {
            clearInterval(timerInterval);
        }

        function startRecording() {
            recordedBlobs = [];
            let options = {
                mimeType: 'video/webm;codecs=vp9'
            };
            mediaRecorder = new MediaRecorder(screenStream, options);

            mediaRecorder.ondataavailable = (event) => {
                if (event.data && event.data.size > 0) {
                    recordedBlobs.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const blob = new Blob(recordedBlobs, {
                    type: 'video/webm'
                });
                const url = window.URL.createObjectURL(blob);
                playback.src = url;

                recordContainer.classList.add('hidden');
                playbackContainer.classList.remove('hidden');

                const filename = 'recorded-video';
                downloadButton.href = url;
                downloadButton.download = `${filename}.webm`;

                @auth
                saveButton.addEventListener('click', () => {
                    const formData = new FormData();
                    formData.append('video', blob, `${filename}.webm`);
                    formData.append('name', filename);

                    fetch("{{ route('upload') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.path) {
                                alert('Video saved successfully');
                                console.log('Video saved successfully:', data.path);
                            } else {
                                console.error('Video save failed:', data.error);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            @endauth
        };

        mediaRecorder.start();
        recordButton.textContent = 'Stop Recording';
        pauseButton.classList.remove('hidden');
        startTimer();
        timer.classList.remove('hidden');
        }

        function startStream(mode) {
            if (mode === 'camera') {
                navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    })
                    .then(mediaStream => {
                        screenStream = mediaStream;
                        screenVideo.srcObject = mediaStream;
                        recordContainer.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error accessing camera:', error));
            } else if (mode === 'screen') {
                navigator.mediaDevices.getDisplayMedia({
                        video: true,
                        audio: true
                    })
                    .then(mediaStream => {
                        screenStream = mediaStream;
                        screenVideo.srcObject = mediaStream;
                        recordContainer.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error accessing screen:', error));
            } else if (mode === 'both') {
                // Tampilkan tombol pilihan PiP
                document.getElementById('pip-label').classList.remove('hidden');
                document.getElementById('pip-top-left').classList.remove('hidden');
                document.getElementById('pip-bottom-left').classList.remove('hidden');
                document.getElementById('pip-top-right').classList.remove('hidden');
                document.getElementById('pip-bottom-right').classList.remove('hidden');

                navigator.mediaDevices.getDisplayMedia({
                        video: true
                    })
                    .then(displayStream => {
                        screenStream = displayStream;
                        screenVideo.srcObject = displayStream;

                        navigator.mediaDevices.getUserMedia({
                                video: true,
                                audio: true
                            })
                            .then(webcamStream => {
                                cameraStream = webcamStream;
                                cameraVideo.srcObject = webcamStream;
                                recordContainer.classList.remove('hidden');
                            })
                            .catch(error => console.error('Error accessing camera:', error));
                    })
                    .catch(error => console.error('Error accessing screen:', error));
            }
        }

        recordCameraButton.addEventListener('click', () => startStream('camera'));
        recordScreenButton.addEventListener('click', () => startStream('screen'));
        recordBothButton.addEventListener('click', () => startStream('both'));

        document.getElementById('pip-top-left').addEventListener('click', () => {
            cameraVideo.style.top = '10px';
            cameraVideo.style.left = '10px';
        });

        document.getElementById('pip-bottom-left').addEventListener('click', () => {
            const screenHeight = screenVideo.offsetHeight;
            const cameraHeight = cameraVideo.offsetHeight;
            cameraVideo.style.top = `${screenHeight - cameraHeight - 10}px`;
            cameraVideo.style.left = '10px';
        });

        document.getElementById('pip-top-right').addEventListener('click', () => {
            cameraVideo.style.top = '10px';
            const screenWidth = screenVideo.offsetWidth;
            const cameraWidth = cameraVideo.offsetWidth;
            cameraVideo.style.left = `${screenWidth - cameraWidth - 10}px`;
        });

        document.getElementById('pip-bottom-right').addEventListener('click', () => {
            const screenHeight = screenVideo.offsetHeight;
            const cameraHeight = cameraVideo.offsetHeight;
            cameraVideo.style.top = `${screenHeight - cameraHeight - 10}px`;
            const screenWidth = screenVideo.offsetWidth;
            const cameraWidth = cameraVideo.offsetWidth;
            cameraVideo.style.left = `${screenWidth - cameraWidth - 10}px`;
        });


        recordButton.addEventListener('click', () => {
            if (isRecording) {
                mediaRecorder.stop();
                recordButton.textContent = 'Start Recording';
                pauseButton.classList.add('hidden');
                stopTimer();
                timer.classList.add('hidden');
            } else {
                startRecording();
            }
            isRecording = !isRecording;
        });

        pauseButton.addEventListener('click', () => {
            if (isPaused) {
                mediaRecorder.resume();
                pauseButton.textContent = 'Pause Recording';
                startTimer();
            } else {
                mediaRecorder.pause();
                pauseButton.textContent = 'Resume Recording';
                stopTimer();
            }
            isPaused = !isPaused;
        });

        deleteButton.addEventListener('click', () => {
            playbackContainer.classList.add('hidden');
            recordContainer.classList.remove('hidden');
        });

        recordAgainButton.addEventListener('click', () => {
            playbackContainer.classList.add('hidden');
            recordContainer.classList.remove('hidden');
        });
    </script>
    <script src="https://cdn.tailwindcss.com/"></script>
    <script>
        // Initialization for ES Users
        import {
            Dropdown,
            Collapse,
            initMDB
        } from "mdb-ui-kit";
        initMDB({
            Dropdown,
            Collapse
        });
    </script>
</body>

</html>
