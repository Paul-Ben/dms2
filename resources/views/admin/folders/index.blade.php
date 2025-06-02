{{-- @extends('dashboards.index')

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
                    @if (session('success'))
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
                                @forelse($folders as $folder)
                                    <tr>
                                        <td>
                                            <a href="{{ route('folders.show', $folder) }}">
                                                <i class="fas fa-folder"></i> {{ $folder->name }}
                                            </a>
                                        </td>
                                        <td>{{ $folder->description }}</td>
                                        <td>{{ $folder->creator->name }}</td>
                                        <td>
                                            @if ($folder->is_private)
                                                <span>Private</span>
                                            @else
                                                <span>Public</span>
                                            @endif
                                        </td>
                                        <td>{{ $folder->documents->count() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('folders.edit', $folder->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('folders.permissions', $folder->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-key"></i>
                                                </a>
                                                <form action="{{ route('folders.destroy', $folder->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this folder?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No folders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}

@extends('dashboards.index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Folders</h3>
                            <div>
                                <a href="{{ route('folders.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Create New Folder
                                </a>
                            </div>
                        </div>
                        <div class="card-tools mt-2">
                            <form action="{{ route('folders.index') }}" method="GET" class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by Folder name or creator..." value="{{ request('search') }}">
                                    <select name="privacy" class="form-control">
                                        <option value="">All Privacy</option>
                                        <option value="public" {{ request('privacy') === 'public' ? 'selected' : '' }}>
                                            Public</option>
                                        <option value="private" {{ request('privacy') === 'private' ? 'selected' : '' }}>
                                            Private</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if (request('search') || request('privacy'))
                                            <a href="{{ route('folders.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Rest of your card-body content remains the same -->
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <!-- Table headers remain the same -->
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
                                <!-- Table body remains the same -->
                                <tbody>
                                    @forelse($folders as $folder)
                                        <tr>
                                            <td>
                                                <a href="{{ route('folders.show', $folder) }}">
                                                    <i class="fas fa-folder"></i> {{ $folder->name }}
                                                </a>
                                            </td>
                                            <td>{{ $folder->description }}</td>
                                            <td>{{ $folder->creator->name }}</td>
                                            <td>
                                                @if ($folder->is_private)
                                                    <span>Private</span>
                                                @else
                                                    <span>Public</span>
                                                @endif
                                            </td>
                                            <td>{{ $folder->documents->count() }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('folders.edit', $folder->id) }}"
                                                        class="btn btn-sm btn-primary me-1"
                                                        title="Edit Folder">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('folders.permissions', $folder->id) }}"
                                                        class="btn btn-sm btn-info me-1"
                                                        title="Set Permissions">
                                                        <i class="fa fa-key"></i>
                                                    </a>
                                                    <form action="{{ route('folders.destroy', $folder->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this folder?')"
                                                            title="Delete Folder">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No folders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Add pagination links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $folders->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Get the search form specifically
            const searchForm = $('form[action="{{ route('folders.index') }}"]');

            // Submit form when privacy filter changes
            $('select[name="privacy"]', searchForm).change(function() {
                searchForm.submit();
            });

            // Debounced search for better performance
            let timer;
            $('input[name="search"]', searchForm).keyup(function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    searchForm.submit();
                }, 500);
            });
        });
    </script>
@endsection
