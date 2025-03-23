@extends('dashboards.index')
@section('content')
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f6f8fc;
            padding: 20px;
        }

        .email-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            padding: 20px;
        }

        .toolbar {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            background: white;
            color: #444;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn:hover {
            background: #f1f3f4;
        }

        .btn svg {
            width: 16px;
            height: 16px;
        }

        .email-header {
            margin-bottom: 20px;
        }

        .subject {
            font-size: 20px;
            color: #202124;
            margin-bottom: 15px;
        }

        .email-meta {
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 10px;
            font-size: 14px;
            color: #5f6368;
        }

        .email-body {
            color: #202124;
            line-height: 1.5;
            margin: 20px 0;
        }

        .attachment {
            border: 1px solid #dadce0;
            border-radius: 4px;
            padding: 12px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .attachment:hover {
            background: #f8f9fa;
        }

        .file-icon {
            width: 36px;
            height: 36px;
            background: #f1f3f4;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: #202124;
        }

        .file-meta {
            font-size: 12px;
            color: #5f6368;
        }

        .preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .preview-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-height: 80vh;
            overflow: auto;
        }

        .close-preview {
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: pointer;
        }
    </style>

    <!-- Button Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">

            </div>
        </div>
    </div>
    <!-- Button End -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="email-container">
                <div class="toolbar">
                    <button class="btn" onclick="replyEmail()">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z" />
                        </svg>
                        Reply
                    </button>
                    <button class="btn" onclick="forwardEmail()">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M14 9v-4l7 7-7 7v-4.1c-5 0-8.5 1.6-11 5.1 1-5 4-10 11-11z" />
                        </svg>
                        Forward
                    </button>
                    <button class="btn" onclick="processEmail()">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                        </svg>
                        Process
                    </button>
                </div>

                <div class="email-header">
                    <div class="subject">Subject: {{$document_received->document->title}}</div>
                    <div class="email-meta">
                        <div>From:</div>
                        <div>{{ $document_received->sender->name }} &lt;{{ $document_received->sender->email }}&gt;</div>
                        <div>To:</div>
                        <div>{{ $document_received->recipient->name }} &lt;{{ $document_received->recipient->email }}m&gt;
                        </div>
                        <div>Date:</div>
                        <div>{{ $document_received->created_at->format('M j, Y') }}</div>
                    </div>
                </div>

                <div class="email-body ml-8">
                    Hi {{ $document_received->recipient->name }},<br><br>

                    {{ $document_received->message }}.<br><br>
                    Best regards,<br>
                    {{ $document_received->sender->name }}
                </div>

                <div class="attachment" id="fileinput">
                    <div class="file-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#5f6368"
                                d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                        </svg>
                    </div>
                    <div class="file-details">
                        <div class="file-name"><a href="{{asset('storage/'.$document_received->document->file_path)}}" target="__blank">{{ $document_received->document->file_path }}</a></div>
                        <div class="file-meta">PDF Document</div>
                        <div id="previewContainer">
                            <img id="imagePreview" style="display: none; max-width: 100%; max-height: 400px;" />
                            <iframe id="pdfPreview" style="display: none; width: 100%; height: 400px;"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="preview-modal" id="previewModal">
                <div class="preview-content">
                    <div class="close-preview" onclick="closePreview()">✕</div>
                    <h2>Document Preview</h2>
                    <div style="padding: 20px;">
                        This is a preview of the document content...
                        <div id="previewContainer">
                            <img id="imagePreview" style="display: none; max-width: 100%; max-height: 400px;" />
                            <iframe id="pdfPreview" style="display: none; width: 100%; height: 400px;"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showPreview() {
            document.getElementById('previewModal').style.display = 'block';
           
            
        }

        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
            const modal = document.getElementById('previewModal');
            const pdfPreview = document.getElementById('pdfPreview');

            // Clear the iframe source when closing the modal
            pdfPreview.src = '';
            modal.style.display = 'none';
        }

        function replyEmail() {
            alert('Opening reply composer...');
        }

        function forwardEmail() {
            alert('Opening forward composer...');
        }

        function processEmail() {
            alert('Processing email...');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('previewModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
  
@endsection
