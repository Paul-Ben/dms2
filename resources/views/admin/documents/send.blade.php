@extends('dashboards.index')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Send Document</h6>
                @if (session('errors'))
                    <span class="alert alert-danger" role="alert">{{ $errors->all() }}</span>
                @endif
                <div>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('document.create') }}">Add Document</a> --}}
                    <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#forwardedMessageModal"
                >
                    Previous Minutes
                </button>
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                            class="fa fa-arrow-left me-2"></i>Back</a>
                </div>

            </div>
            <div class="container">
                <h1></h1>
                <form action="{{ route('document.senddoc', $document) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="recipient_email">Recipient</label>
                       
                        <select class="form-control selectpicker" name="recipient_id[]" id="recipients" multiple="multiple">
                            <option value="" disabled>Select recipients</option>
                            @foreach ($recipients as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->userDetail->tenant_department->name ?? $user->userDetail->tenant->name }} | {{$user->name}} |{{ $user->userDetail->designation ?? $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="selected-items" id="selectedItems"></div>
                    </div>
                    <div class="form-group" hidden>
                        <label for="subject">Subject</label>
                        <input type="text" value="{{ $document->id }}" class="form-control" id="subject"
                            name="document_id" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <div class="col-sm-12 col-xl-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Attach Document</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Send</button>
                </form>
            </div>
        </div>
    </div>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="forwardedMessageModal" tabindex="-1" aria-labelledby="forwardedMessageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forwardedMessageModalLabel">
                            Previous Minutes
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($document_locations as $location)
                            <div class="forwarded-content">
                            <p>---------- {{$document->docuent_number}} ----------</p>
                            <p>
                                <strong>From:</strong> {{ $location->sender->name }}
                                &lt;{{ $location->sender->userDetail->designation }}&gt;
                            </p>
                            <p>
                                <strong>Date:</strong> {{$location->updated_at->format('M j, Y g:i A')}}
                            </p>
                            <p>
                                <strong>Subject:</strong> {{$document->title}}
                            </p>
                            <p>
                                <strong>To:</strong> {{$location->recipient->name}}
                                &lt;{{ $location->recipient->userDetail->designation }}&gt;
                            </p>
                            <br />
                            <p>Hi {{$location->recipient->name}},</p>
                            <p>
                                {{ $location->message }}
                            </p>
                           
                            <p>Best regards,</p>
                            <p>{{ $location->sender->name }}</p>
                        </div>
                        @endforeach
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#recipients').selectpicker({
                theme: 'bootstrap4',
                placeholder: "Select recipients",
                allowClear: true,
                tags: false,
            });
        });
    </script>
@endsection
