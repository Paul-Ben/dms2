{{-- @extends('dashboards.index')
@section('content')
<style>
    .dropdown-footer {
        border-top: 1px solid #871313;
        background: #f8f9fa;
    }
</style>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Send Document</h6>
                @if (session('errors'))
                    <span class="alert alert-danger" role="alert">{{ $errors->all() }}</span>
                @endif
                <div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#forwardedMessageModal">
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
                        <label for="recipient_email">Select Staff to minute to:</label>
                        
                        <select class="form-control selectpicker" name="recipient_id[]" id="recipients" multiple
                            data-live-search="true" data-actions-box="true" data-style="btn-outline-primary"
                            title="Select recipients">
                            @foreach ($recipients as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->userDetail->tenant_department->name ?? $user->userDetail->tenant->name }} |
                                    {{ $user->name }} |
                                    {{ $user->userDetail->designation ?? $user->name }}
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
                                <p>---------- {{ $document->docuent_number }} ----------</p>
                                <p>
                                    <strong>From:</strong> {{ $location->sender->name }}
                                    &lt;{{ $location->sender->userDetail->designation }}&gt;
                                </p>
                                <p>
                                    <strong>Date:</strong> {{ $location->updated_at->format('M j, Y g:i A') }}
                                </p>
                                <p>
                                    <strong>Subject:</strong> {{ $document->title }}
                                </p>
                                <p>
                                    <strong>To:</strong> {{ $location->recipient->name }}
                                    &lt;{{ $location->recipient->userDetail->designation }}&gt;
                                </p>
                                <br />
                                <p>Hi {{ $location->recipient->name }},</p>
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
        $(document).ready(function () {
            // Initialize selectpicker
            $('.selectpicker').selectpicker();
    
            // Inject footer with "Done" button once the dropdown is shown
            $('#recipients').on('shown.bs.select', function () {
                // Avoid duplicate button
                if (!$('.bs-done-btn').length) {
                    const doneBtn = `
                        <div class="dropdown-footer text-end px-2 py-1">
                            <button type="button" class="btn btn-sm btn-primary bs-done-btn">Done</button>
                        </div>
                    `;
    
                    // Append to the dropdown menu
                    $('.dropdown-menu.inner').parent().append(doneBtn);
                }
            });
    
            // Close dropdown on "Done" click
            $(document).on('click', '.bs-done-btn', function () {
                $('#recipients').selectpicker('toggle');
            });
        });
    </script>
    
@endsection --}}

@extends('dashboards.index')
@section('content')
    <style>
        .dropdown-footer {
            border-top: 1px solid #dee2e6;
            background: #f8f9fa;
            padding: 8px 12px;
            text-align: right;
        }

        .selected-items {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .selected-item {
            display: inline-flex;
            align-items: center;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
        }

        .selected-item .remove-item {
            margin-left: 5px;
            cursor: pointer;
            color: #6c757d;
        }

        .selected-item .remove-item:hover {
            color: #dc3545;
        }

        @media (max-width: 767.98px) {
            .d-flex.align-items-center.justify-content-between {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .d-flex.align-items-center.justify-content-between>div {
                margin-top: 10px;
                width: 100%;
            }

            .btn-group {
                width: 100%;
            }

            .bootstrap-select .dropdown-toggle {
                width: 100% !important;
            }
        }
    </style>

    <div class="container-fluid pt-3 pt-md-4 px-2 px-md-3">
        <div class="bg-light rounded p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between mb-3 mb-md-4">
                <h6 class="mb-0">Send Document</h6>
                @if (session('errors'))
                    <span class="alert alert-danger" role="alert">{{ $errors->all() }}</span>
                @endif
                <div class="d-flex flex-wrap" style="gap: 8px;">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                        data-target="#forwardedMessageModal">
                        Previous Minutes
                    </button>
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                            class="fa fa-arrow-left mr-2"></i>Back</a>
                </div>
            </div>

            <div class="container px-0">
                <form action="{{ route('document.senddoc', $document) }}" method="POST" enctype="multipart/form-data"
                    >
                    @csrf
                    <div class="form-group mb-3">
                        <label for="recipients">Select Staff to minute to:</label>
                        <select class="form-control selectpicker" name="recipient_id[]" id="recipients" multiple
                            data-live-search="true" data-actions-box="true" data-style="btn-outline-primary"
                            title="Select recipients">
                            @foreach ($recipients as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->userDetail->tenant_department->name ?? $user->userDetail->tenant->name }} |
                                    {{ $user->name }} |
                                    {{ $user->userDetail->designation ?? $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="selected-items" id="selectedItems"></div>
                    </div>

                    <div class="form-group" hidden>
                        <input type="text" value="{{ $document->id }}" class="form-control" name="document_id" required>
                    </div>

                    {{-- <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div> --}}
                    <div class="form-group mb-3">
                        <label for="message">Message</label>
                        <!-- Suggestion Chips -->
                        <div class="mb-3" id="suggestion-container" style="display: none;">
                            <label class="form-label">Suggestions:</label>
                            <div id="suggestions">
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Please treat.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Please act.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Please treat as urgent.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Please advise.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Please bring up.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">For your necessary action.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Please Keep in view.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">This is for your information.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Write a Brief.</span>
                                <span class="badge bg-primary suggestion" style="cursor:pointer;">Put away.</span>
                            </div>
                        </div>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>


                    <div class="col-12 col-md-6 mb-3 pl-0 mt-3">
                        <label>Attach Document</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Send</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal (same as before) -->
    <div class="modal fade" id="forwardedMessageModal" tabindex="-1" role="dialog"
        aria-labelledby="forwardedMessageModalLabel" aria-hidden="true">
        <!-- Modal content remains the same -->
    </div>

    <script>
        $(document).ready(function() {
            // Initialize selectpicker with better configuration
            $('.selectpicker').selectpicker({
                noneSelectedText: 'Select recipients',
                selectedTextFormat: 'count > 2',
                countSelectedText: '{0} selected',
                liveSearch: true,
                liveSearchPlaceholder: 'Search recipients...',
                style: 'btn-outline-primary',
                size: 'auto',
                width: '100%',
                dropupAuto: false
            });

            // Update selected items display
            function updateSelectedItems() {
                const selectedItems = $('#recipients').find('option:selected');
                const selectedItemsContainer = $('#selectedItems');
                selectedItemsContainer.empty();

                if (selectedItems.length === 0) {
                    selectedItemsContainer.append('<span class="text-muted">No recipients selected</span>');
                } else {
                    selectedItems.each(function() {
                        const itemText = $(this).text().split('|')[1].trim();
                        const itemValue = $(this).val();
                        selectedItemsContainer.append(`
                    <span class="selected-item">
                        ${itemText}
                        <span class="remove-item" data-value="${itemValue}">&times;</span>
                    </span>
                `);
                    });
                }
            }

            // Initial update
            updateSelectedItems();

            // Handle changes to the selectpicker
            $('#recipients').on('changed.bs.select', function() {
                updateSelectedItems();
            });

            // Handle click on remove item buttons
            $(document).on('click', '.remove-item', function() {
                const valueToRemove = $(this).data('value');
                $('#recipients').selectpicker('deselect', valueToRemove);
                updateSelectedItems();
            });

            // Add custom footer with close button to the dropdown
            $('#recipients').on('shown.bs.select', function() {
                // Check if footer already exists
                if ($('.selectpicker-footer').length === 0) {
                    const footer = `
                <div class="dropdown-footer selectpicker-footer">
                    <button type="button" class="btn btn-sm btn-primary close-selectpicker">
                        <i class="fa fa-check mr-1"></i> Done
                    </button>
                </div>
            `;
                    $('.bootstrap-select .dropdown-menu').append(footer);
                }
            });

            // Close dropdown when "Done" button is clicked
            $(document).on('click', '.close-selectpicker', function() {
                $('#recipients').selectpicker('toggle');
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.bootstrap-select').length &&
                    !$(e.target).hasClass('bs-searchbox') &&
                    $('.bootstrap-select').hasClass('open')) {
                    $('#recipients').selectpicker('toggle');
                }
            });
        });
    </script>

    <script>
        const textarea = document.getElementById('message');
        const suggestionContainer = document.getElementById('suggestion-container');
        const suggestions = document.querySelectorAll('.suggestion');

        // Show suggestions on focus
        textarea.addEventListener('focus', () => {
            suggestionContainer.style.display = 'block';
        });

        // Hide suggestions when focus is lost (optional)
        textarea.addEventListener('blur', () => {
            setTimeout(() => {
                suggestionContainer.style.display = 'none';
            }, 200); // delay to allow chip click before hiding
        });

        // Handle suggestion click
        suggestions.forEach(suggestion => {
            suggestion.addEventListener('click', () => {
                textarea.value = textarea.value.trim() ?
                    textarea.value + ' ' + suggestion.textContent :
                    suggestion.textContent;
                textarea.focus();
            });
        });
    </script>

@endsection
