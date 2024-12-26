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
        <!-- Button End -->

        <!-- Table Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Organisation Management</h6>
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{ route('organisation.create') }}">Add Tenant</a>
                        <a class="btn btn-sm btn-primary" href="{{ route('dashboard') }}"><i
                                class="fa fa-arrow-left me-2"></i>Back</a>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organisations as $key => $tenant)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $tenant->name }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td>{{ $tenant->phone }}</td>
                                    <td>{{ $tenant->status }}</td>
                                    <td>
                                        <div class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle"
                                                data-bs-toggle="dropdown">Details</a>
                                            <div class="dropdown-menu">
                                                <a href="{{route('organisation.edit', $tenant)}}" class="dropdown-item">Edit</a>
                                                <form action="{{ route('organisation.delete', $tenant) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                   
                                                    <button class="dropdown-item" style="background-color: rgb(235, 78, 78)" type="submit">Delete</button>
                                                </form> 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{$organisations->links('pagination::bootstrap-5')}}</div>
            </div>
        </div>
        <!-- Table End -->
    @endsection
