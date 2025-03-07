@extends('dashboards.index')
@section('content')
    <!-- Button Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Button End -->

    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">User Management</h6>
                <div>
                    <a class="btn btn-sm btn-primary" href="{{ route('user.create') }}">Add User</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('dashboard') }}"><i class="fa fa-arrow-left me-2"></i>Back</a>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{route('user.view', $user)}}">{{ $user->user->name }}</a></td>
                                <td>{{ $user->user->email }}</td>

                                <td>{{ $user->user->default_role }}</td>
                                <td>
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Details</a>
                                        <div class="dropdown-menu">
                                            <a href="{{route('user.edit', $user)}}" class="dropdown-item">Edit</a>
                                            {{-- <a href="delete_student.html" class="dropdown-item" style="background-color: rgb(239, 79, 79)">Delete</a> --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endsection
