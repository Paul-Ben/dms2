@extends('dashboards.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Folder</h3>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('folders.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Folder Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
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
                                      rows="3">{{ old('description') }}</textarea>
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
                                @foreach($folders as $folder)
                                    <option value="{{ $folder->id }}" 
                                            {{ old('parent_id') == $folder->id ? 'selected' : '' }}>
                                        {{ $folder->name }}
                                    </option>
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
                                       {{ old('is_private') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_private">Private Folder</label>
                            </div>
                        </div>

                        <div class="form-group" id="permissions-section" style="display: none;">
                            <label>Folder Permissions</label>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control select2" id="user-search">
                                            <option value="">Search for a user...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="permission-type">
                                            <option value="read">Read</option>
                                            <option value="write">Write</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" id="add-permission">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="permissions-table">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Permission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Permissions will be added here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Folder</button>
                            <a href="{{ route('folders.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Search for a user...",
            allowClear: true
        });

   

        // Handle private folder toggle
        $('#is_private').on('change', function() {
            $('#permissions-section').toggle(this.checked);
        });


        // Handle adding permissions
        $('#add-permission').on('click', function() {
            const userId = $('#user-search').val();
            const userName = $('#user-search option:selected').data('name');
            const permission = $('#permission-type').val();

            if (!userId) {
                alert('Please select a user');
                return;
            }

            // Check if user is already added
            if ($(`#permissions-table tr[data-user-id="${userId}"]`).length > 0) {
                alert('This user already has permissions assigned');
                return;
            }

            // Add new row
            const row = `
                <tr data-user-id="${userId}">
                    <td>${userName}</td>
                    <td>
                        <select class="form-control permission-select" name="permissions[${userId}][permission]">
                            <option value="read" ${permission === 'read' ? 'selected' : ''}>Read</option>
                            <option value="write" ${permission === 'write' ? 'selected' : ''}>Write</option>
                            <option value="admin" ${permission === 'admin' ? 'selected' : ''}>Admin</option>
                        </select>
                        <input type="hidden" name="permissions[${userId}][user_id]" value="${userId}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-permission">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#permissions-table tbody').append(row);

            // Clear selection
            $('#user-search').val('').trigger('change');
        });

        // Handle removing permissions
        $(document).on('click', '.remove-permission', function() {
            $(this).closest('tr').remove();
        });
    });
</script> --}}
<script>
    $(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Search for a user...",
        allowClear: true
    });

    // Show permissions section if "Private Folder" is already checked
    if ($('#is_private').is(':checked')) {
        $('#permissions-section').show();
    }

    // Handle private folder toggle
    $('#is_private').on('change', function() {
        $('#permissions-section').toggle(this.checked);
    });

    // Handle adding permissions
    $('#add-permission').on('click', function() {
        const userId = $('#user-search').val();
        const userName = $('#user-search option:selected').data('name');
        const permission = $('#permission-type').val();

        if (!userId) {
            alert('Please select a user');
            return;
        }

        // Check if user is already added
        if ($(`#permissions-table tr[data-user-id="${userId}"]`).length > 0) {
            alert('This user already has permissions assigned');
            return;
        }

        // Add new row
        const row = `
            <tr data-user-id="${userId}">
                <td>${userName}</td>
                <td>
                    <select class="form-control permission-select" name="permissions[${userId}][permission]">
                        <option value="read" ${permission === 'read' ? 'selected' : ''}>Read</option>
                        <option value="write" ${permission === 'write' ? 'selected' : ''}>Write</option>
                        <option value="admin" ${permission === 'admin' ? 'selected' : ''}>Admin</option>
                    </select>
                    <input type="hidden" name="permissions[${userId}][user_id]" value="${userId}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-permission">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#permissions-table tbody').append(row);

        // Clear selection
        $('#user-search').val('').trigger('change');
    });

    // Handle removing permissions
    $(document).on('click', '.remove-permission', function() {
        $(this).closest('tr').remove();
    });
});

</script>

@endsection