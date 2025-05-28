@extends('dashboards.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Folders</h3>
                    <div class="card-tools">
                        <a href="{{ route('folders.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create New Folder
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created By</th>
                                    <th>Privacy</th>
                                    <th>Documents</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($folders as $folder)
                                    <tr>
                                        <td>
                                            <a href="{{ route('folders.show', $folder) }}">
                                                <i class="fas fa-folder"></i> {{ $folder->name }}
                                            </a>
                                        </td>
                                        <td>{{ $folder->description }}</td>
                                        <td>{{ $folder->creator->name }}</td>
                                        <td>
                                            @if($folder->is_private)
                                                <span class="badge badge-warning">Private</span>
                                            @else
                                                <span class="badge badge-success">Public</span>
                                            @endif
                                        </td>
                                        <td>{{ $folder->documents->count() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('folders.edit', $folder) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('folders.destroy', $folder) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this folder?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 