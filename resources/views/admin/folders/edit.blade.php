@extends('dashboards.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
               
                <div class="card-header">
                    <h3 class="card-title">Edit Folder: {{ $folder->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('folders.update', $folder) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Folder Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $folder->name) }}" 
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $folder->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Parent Folder</label>
                            <select class="form-control @error('parent_id') is-invalid @enderror" 
                                    id="parent_id" 
                                    name="parent_id">
                                <option value="">None (Root Folder)</option>
                                @foreach($folders as $potentialParent)
                                    @if($potentialParent->id !== $folder->id)
                                        <option value="{{ $potentialParent->id }}" 
                                                {{ old('parent_id', $folder->parent_id) == $potentialParent->id ? 'selected' : '' }}>
                                            {{ $potentialParent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('parent_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="is_private" 
                                       name="is_private" 
                                       value="1" 
                                       {{ old('is_private', $folder->is_private) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_private">Private Folder</label>
                            </div>
                        </div>

                        <div class="form-group" id="permissions-section" 
                             style="display: {{ $folder->is_private ? 'block' : 'none' }};">
                            <label>Folder Permissions</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    <select class="form-control" 
                                                            name="permissions[{{ $user->id }}]">
                                                        @php
                                                            $userPermission = $folder->permissions()
                                                                ->where('user_id', $user->id)
                                                                ->first();
                                                        @endphp
                                                        <option value="read" 
                                                                {{ $userPermission && $userPermission->permission === 'read' ? 'selected' : '' }}>
                                                            Read
                                                        </option>
                                                        <option value="write" 
                                                                {{ $userPermission && $userPermission->permission === 'write' ? 'selected' : '' }}>
                                                            Write
                                                        </option>
                                                        <option value="admin" 
                                                                {{ $userPermission && $userPermission->permission === 'admin' ? 'selected' : '' }}>
                                                            Admin
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Folder</button>
                            <a href="{{ route('folders.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('is_private').addEventListener('change', function() {
        document.getElementById('permissions-section').style.display = 
            this.checked ? 'block' : 'none';
    });
</script>
@endpush
@endsection 