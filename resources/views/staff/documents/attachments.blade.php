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
                    <h6 class="mb-0">File Attachments</h6>
                    <div>
                        {{-- <a class="btn btn-sm btn-primary" href="{{ route('department.create') }}">Add Department</a> --}}
                        <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                                class="fa fa-arrow-left me-2"></i>Back</a>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Attached File</th>
                                {{-- <th scope="col">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $key => $attachment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $attachment->attachment }}</td>
                                    <td><a href="{{asset('documents/attachments/' . $attachment->attachment)}}">Attachment</a></td>
                                    
                                    {{-- <td>
                                        <div class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle"
                                                data-bs-toggle="dropdown">Details</a>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('department.edit', $department) }}"
                                                    class="dropdown-item">Edit</a>
                                                <form action="{{ route('department.delete', $department) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="dropdown-item" style="background-color: rgb(235, 78, 78)"
                                                        type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $attachments->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
        <!-- Table End -->
    @endsection
