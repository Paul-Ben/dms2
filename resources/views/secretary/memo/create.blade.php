@extends('dashboards.index')
@section('content')
    <div>

        <!-- Button Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    @if (session('errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Button End -->
        <!-- Form Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h6 class="mb-4">Create a Document Record</h6>
                                <p>Fill All Fields Required</p>
                            </div>
                            <div>
                                <a class="btn btn-sm btn-primary" href="{{ route('document.index') }}"><i
                                        class="fa fa-arrow-left me-2"></i>Back</a>
                            </div>

                        </div>

                        <form method="POST" action="{{ route('memo.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Title/Subject</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    {{-- <label for="exampleInputEmail1" class="form-label">Upload Document</label>
                                    <input type="file" name="file_path" class="form-control"> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Document Number</label>
                                    <input type="text" name="document_number" class="form-control"
                                        value="{{ 'BN/doc/' . rand(0, 9999) . date('YmdHis') }}"
                                        placeholder="document number" readonly>
                                    <input type="text" name="user_id" class="form-control" value="{{ Auth::user()->id }}"
                                        placeholder="document number" hidden>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Message/Body</label>
                                    <div class="position-relative">
                                        <textarea class="form-control" name="content" id="memoContent" cols="30" rows="5"></textarea>
                                        <button type="button" id="speechButton" class="btn btn-link position-absolute"
                                            style="right: 10px; bottom: 10px;">
                                            <i class="fas fa-microphone" id="micIcon"
                                                style="font-size: 1.2rem; color: #6c757d;"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- Form End -->

        <style>
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.2);
                }

                100% {
                    transform: scale(1);
                }
            }
        </style>

        <script>
            // Speech Recognition Setup
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;

            const speechButton = document.getElementById('speechButton');
            const micIcon = document.getElementById('micIcon');
            const memoContent = document.getElementById('memoContent');
            let isListening = false;

            speechButton.addEventListener('click', () => {
                if (!isListening) {
                    // Start listening
                    recognition.start();
                    isListening = true;
                    micIcon.style.color = '#dc3545'; // Red color when active
                    micIcon.style.animation = 'pulse 1.5s infinite';
                } else {
                    // Stop listening
                    recognition.stop();
                    isListening = false;
                    micIcon.style.color = '#6c757d';
                    micIcon.style.animation = 'none';
                }
            });

            recognition.onresult = (event) => {
                const transcript = Array.from(event.results)
                    .map(result => result[0])
                    .map(result => result.transcript)
                    .join('');

                memoContent.value = transcript;
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
                isListening = false;
                micIcon.style.color = '#6c757d';
                micIcon.style.animation = 'none';
            };
        </script>
    </div>
@endsection
