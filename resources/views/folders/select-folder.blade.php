{{-- @extends('dashboards.index')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h6 class="mb-0">Select Folder for Document: {{ $document->title }}</h6><br>
                <p>Document Number: {{ $document->docuent_number }}</p> 
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                <i class="fa fa-arrow-left me-2"></i>Back
            </a>
        </div>

        @if(session('message'))
            <div class="alert alert-{{ session('alert-type') }}">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any() )
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            @forelse($folders as $folder)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $folder->name }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($folder->description ?? '', 100) }}
                            </p>
                            <form action="{{ route('folders.add-documents', $folder) }}" method="POST">
                                @csrf
                                <input type="text" name="document_id" value="{{ $document->id }}" hidden>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Add to this Folder
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No folders available. <a href="{{ route('folders.create') }}">Create a new folder</a>
                    </div>
                </div>
            @endforelse
        </div>
       
        <div class="d-flex justify-content-center mt-4">
            {{ $folders->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection  --}}
@extends('dashboards.index')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h6 class="mb-0">Select Folder for Document: {{ $document->title }}</h6><br>
                <p>Document Number: {{ $document->docuent_number }}</p> 
            </div>
            <div>
                <form action="{{ route('folders.select', $document) }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Search folders..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('folders.select', $document) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                <i class="fa fa-arrow-left me-2"></i>Back
            </a>
        </div>

        @if(session('message'))
            <div class="alert alert-{{ session('alert-type') }}">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            @forelse($folders as $folder)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $folder->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($folder->description ?? 'No description', 100) }}
                            </p>
                            <div class="mt-auto">
                                <form action="{{ route('folders.add-documents', $folder) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="document_id" value="{{ $document->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-folder-plus me-1"></i> Add to Folder
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        @if(request('search'))
                            No folders found matching "{{ request('search') }}". 
                            <a href="{{ route('folders.select', $document) }}">Clear search</a>
                        @else
                            No folders available. <a href="{{ route('folders.create') }}">Create a new folder</a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $folders->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection