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
                    <h6 class="mb-0">Department Management</h6>
                    {{-- <div>
                        <form method="GET" action="{{route('search.dept')}}">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search items..."
                                    value="">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div> --}}
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{ route('department.create') }}">Add Department</a>
                        <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                                class="fa fa-arrow-left me-2"></i>Back</a>
                    </div>

                </div>
                <div class="table-responsive">
                    <table id="superDepartment" class="table text-start align-middle table-bordered table-hover mb-0">
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
                            @foreach ($departments as $key => $department)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->email }}</td>
                                    <td>{{ $department->phone }}</td>
                                    <td>{{ $department->status }}</td>
                                    <td>
                                        <div class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle"
                                                data-bs-toggle="dropdown">Details</a>
                                            <div class="dropdown-menu">
                                                <a href="{{route('department.edit', $department)}}" class="dropdown-item">Edit</a>
                                                <form action="{{ route('department.delete', $department) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                <div class="mt-4">{{$departments->links('pagination::bootstrap-5')}}</div>
            </div>
        </div>
        <!-- Table End -->
        <script>
            $(document).ready(function() {
                $('#superDepartment').DataTable({
                    responsive: true,
                    autoWidth: false,
                    paging: true, // Enable pagination
                    searching: true, // Enable search
                    ordering: true, // Enable sorting
                    lengthMenu: [10, 25, 50, 100], // Dropdown for showing entries
                    columnDefs: [{
                            orderable: false,
                            targets: -1
                        } // Disable sorting on last column (Actions)
                    ],
                    language: {
                        searchPlaceholder: "Search here...",
                        zeroRecords: "No matching records found",
                        lengthMenu: "Show entries",
                        // info: "Showing START to END of TOTAL entries",
                        infoFiltered: "(filtered from MAX total entries)",
                    }
                });
            });
        </script>
    @endsection
