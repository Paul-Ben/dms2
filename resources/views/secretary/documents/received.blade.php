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
                <h6 class="mb-0">Incoming Mails</h6>
                <div>
                    <a class="btn btn-sm btn-primary" href="{{ route('document.create') }}">Add Document</a>
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i class="fa fa-arrow-left me-2"></i>Back</a>
                </div>

            </div>
            <div class="table-responsive">
                <table id="secReceivedDocs" class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Document No</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Sent By</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            {{-- <th scope="col">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($received_documents as $key => $received)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td><a href="{{route('document.view', $received)}}">
                                    {{$received->document->docuent_number}}
                                </a></td>
                                <td>{{$received->document->title}}</td>
                                <td>{{$received->sender_details->name}}</td>
                                <td>{{$received->document->status}}</td>
                                <td>{{$received->document->updated_at->format('M j, Y g:i A')}}</td>
                                {{-- <td>
                                    <a href="{{route('document.view', $received)}}" class="nav-item">View</a>
                                </td> --}}
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td></td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Table End -->
    <script>
        $(document).ready(function() {
            $('#secReceivedDocs').DataTable({
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