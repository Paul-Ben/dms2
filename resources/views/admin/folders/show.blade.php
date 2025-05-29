@extends('dashboards.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            @if($folder->parent)
                                <a href="{{ route('folders.show', $folder->parent) }}" class="text-muted">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            @endif
                            {{ $folder->name }}
                        </h3>
                        <div>
                            <a href="{{ route('folders.edit', $folder) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Folder
                            </a>
                            <a href="{{ route('folders.create', ['parent_id' => $folder->id]) }}" class="btn btn-success">
                                <i class="fas fa-folder-plus"></i> New Subfolder
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($folder->description)
                        <div class="alert alert-info">
                            {{ $folder->description }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Subfolders Section -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Subfolders</h4>
                                </div>
                                <div class="card-body">
                                    @if($folder->children->count() > 0)
                                        <div class="list-group">
                                            @foreach($folder->children as $subfolder)
                                                <a href="{{ route('folders.show', $subfolder) }}" 
                                                   class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">
                                                            <i class="fas fa-folder text-warning"></i>
                                                            {{ $subfolder->name }}
                                                        </h5>
                                                        <small>
                                                            {{ $subfolder->documents_count }} documents
                                                        </small>
                                                    </div>
                                                    @if($subfolder->description)
                                                        <p class="mb-1">{{ Str::limit($subfolder->description, 100) }}</p>
                                                    @endif
                                                    <small>
                                                        Created by {{ $subfolder->creator->name }}
                                                        @if($subfolder->is_private)
                                                            <span class="badge badge-info">Private</span>
                                                        @endif
                                                    </small>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No subfolders found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Documents</h4>
                                </div>
                                <div class="card-body">
                                    @if($folder->documents->count() > 0)
                                        <div class="list-group">
                                            @foreach($folder->documents as $document)
                                                <div class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">
                                                            <i class="fas fa-file text-primary"></i>
                                                            <a href="{{ route('document.view', $document->id) }}" class="text-decoration-none">
                                                                {{ $document->title }}
                                                            </a>
                                                        </h5>
                                                        <small>
                                                            {{ $document->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-1">{{ $document->docuent_number }} - {{ Str::limit($document->description, 100) }}</p>
                                                    <small>
                                                        @if($document->is_private)
                                                            <span class="badge badge-info">Private</span>
                                                        @endif
                                                    </small>
                                                    <div class="btn-group">
                                                        <a href="{{ route('document.view', $document) }}" class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        <a href="{{ route('folders.remove-document', ['folder' => $folder->id, 'document' => $document->id]) }}" class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i> Remove
                                                        </a>
                                                        {{-- <form action="{{ route('folders.remove-document', ['folder' => $folder->id, 'document' => $document->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this document from the folder?')">
                                                                <i class="fa fa-trash"></i> Remove
                                                            </button>
                                                        </form> --}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No documents found in this folder.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($folder->is_private)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Folder Permissions</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($folder->permissions as $permission)
                                                <tr>
                                                    <td>{{ $permission->user->name }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $permission->permission === 'admin' ? 'danger' : ($permission->permission === 'write' ? 'warning' : 'info') }}">
                                                            {{ ucfirst($permission->permission) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 