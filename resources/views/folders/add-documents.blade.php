@extends('dashboards.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Documents to Folder: {{ $folder->name }}</h4>
                </div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-{{ session('alert-type') }}">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form action="{{ route('folders.add-documents', $folder) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Select Documents to Add</label>
                            <div class="row">
                                @forelse($availableDocuments as $document)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" 
                                                           class="form-check-input" 
                                                           name="document_ids[]" 
                                                           value="{{ $document->id }}" 
                                                           id="document_{{ $document->id }}">
                                                    <label class="form-check-label" for="document_{{ $document->id }}">
                                                        {{ $document->title }}
                                                        <small class="d-block text-muted">
                                                            Document #: {{ $document->docuent_number }}
                                                        </small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">No available documents to add to this folder.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Add Selected Documents</button>
                            <a href="{{ route('folders.show', $folder) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 