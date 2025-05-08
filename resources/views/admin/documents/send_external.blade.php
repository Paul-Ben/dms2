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
                    <a class="btn btn-sm btn-primary" href="{{ route('document.create') }}">Add Document</a>
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                            class="fa fa-arrow-left me-2"></i>Back</a>
                </div>

            </div>
            <div class="container">
                <h1></h1>
                <form action="{{ route('document.senddoc', $document) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="recipient_email">Select Staff to minute to:</label>
                       
                        <select class="form-control selectpicker" name="recipient_id[]" id="recipients" multiple="multiple">
                            <option value="" disabled>Select recipients</option>
                            @foreach ($recipients as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->userDetail->tenant->name ?? 'Citizen User' }} | {{ $user->userDetail->designation ?? $user->name }}
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
                            <span class="badge bg-primary suggestion" style="cursor:pointer;">Please treat as urgent.</span>
                            <span class="badge bg-primary suggestion" style="cursor:pointer;">For your necessary action.</span>
                            <span class="badge bg-primary suggestion" style="cursor:pointer;">For your attention please.</span>
                        </div>
                    </div>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Send</button>
                </form>
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
                textarea.value = textarea.value.trim()
                    ? textarea.value + ' ' + suggestion.textContent
                    : suggestion.textContent;
                textarea.focus();
            });
        });
    </script>
@endsection
