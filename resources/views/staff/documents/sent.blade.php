@extends('dashboards.index')
@section('content')
    <!-- Button Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">

            </div>
        </div>
    </div>
    <!-- Button End -->

    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Sent Documents</h6>
                <div>
                    <a class="btn btn-sm btn-primary" href="{{ route('document.create') }}">Add Document</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('dashboard') }}"><i
                            class="fa fa-arrow-left me-2"></i>Back</a>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Document No</th>
                            <th scope="col">Title</th>
                            <th scope="col">Sent To</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sent_documents as $key => $sent)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{ route('document.view', $sent) }}">
                                        {{ $sent->document->docuent_number }}
                                    </a>
                                </td>
                                <td>{{ $sent->document->title }}</td>
                                <td>
                                    <p class="text-sm">{{ $recipient[0]->name }}</p>
                                </td>
                                <td>{{ $sent->message }}</td>
                                <td>
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle"
                                            data-bs-toggle="dropdown">Details</a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('document.view_sent', $sent) }}"
                                                class="dropdown-item">View</a>
                                            {{-- <a href="delete_student.html" class="dropdown-item" style="background-color: rgb(239, 79, 79)">Delete</a> --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="6">No Data Found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            @if ($sent_documents->count() > 0)
                <div class="mt-3">
                    {{ $sent_documents->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
    <!-- Table End -->
@endsection
