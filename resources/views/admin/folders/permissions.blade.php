@extends('dashboards.index')

@section('content')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Folder Permissions - {{ $folder->name }}</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('folders.update-permissions', $folder->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_private" name="is_private"
                                        value="1" {{ $folder->is_private ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_private">Private Folder</label>
                                </div>
                            </div>

                            <div class="form-group" id="permissions-section"
                                style="display: {{ $folder->is_private ? 'block' : 'none' }}">
                                <label>Folder Permissions</label>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control select2" id="user-search">
                                                <option value="">Search for a user...</option>
                                                @foreach ($users as $user)
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
                                            @foreach ($folder->users as $user)
                                                <tr data-user-id="{{ $user->id }}">
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        <select class="form-control permission-select select2"
                                                            name="permissions[{{ $user->id }}][permission]">
                                                            <option value="read"
                                                                {{ $user->pivot->permission === 'read' ? 'selected' : '' }}>
                                                                Read</option>
                                                            <option value="write"
                                                                {{ $user->pivot->permission === 'write' ? 'selected' : '' }}>
                                                                Write</option>
                                                            <option value="admin"
                                                                {{ $user->pivot->permission === 'admin' ? 'selected' : '' }}>
                                                                Admin</option>
                                                        </select>
                                                        <input type="hidden"
                                                            name="permissions[{{ $user->id }}][user_id]"
                                                            value="{{ $user->id }}">
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-permission">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Permissions</button>
                                <a href="{{ route('folders.index') }}" class="btn btn-secondary">Back to Folders</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <!-- jQuery (required first) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS (after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // // Initialize Select2
            // $('.select2').select2({
            //     placeholder: "Search for a user...",
            //     allowClear: true
            // });

            // // Show permissions section if "Private Folder" is already checked
            // if ($('#is_private').is(':checked')) {
            //     $('#permissions-section').show();
            // }

            // // Handle private folder toggle
            // $('#is_private').on('change', function() {
            //     $('#permissions-section').toggle(this.checked);
            // });
            // Initialize Select2

            // Show/hide permissions section on page load
            if ($('#is_private').is(':checked')) {
                $('#permissions-section').show();
            } else {
                $('#permissions-section').hide();
            }

            // Handle private folder toggle
            $('#is_private').on('change', function() {
                if (this.checked) {
                    $('#permissions-section').show();
                } else {
                    $('#permissions-section').hide();
                }
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

             $('.select2').select2({
                placeholder: "Search for a user...",
                allowClear: true
            });
        });


    </script>
@endsection
