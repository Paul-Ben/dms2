@extends('dashboards.index')
@section('content')
    <!-- Button Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
               @if (session('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
               @endif
               <script>
                @if(session()->has('toastr'))
                    {!! session('toastr') !!}
                @endif
            </script>
            </div>
        </div>
    </div>
    <!-- Button End -->

    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Receipts</h6>
                <div>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('document.file') }}">File New Document</a> --}}
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('document.create') }}">Add Document</a> --}}
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i class="fa fa-arrow-left me-2"></i>Back</a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="userReceipts" class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Document No</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receipts as $key => $receipt)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{$receipt->document_no}}</td>
                                <td>{{$receipt->reference}}</td>
                                <td>{{$receipt->transAmount}}</td>
                                <td>{{$receipt->transDate}}</td>
                                <td>
                                    <a href="{{route('receipt.show', $receipt)}}" target="__blank">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="6">No Data Found</td>
                                </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="pt-4">
                    {{$receipts->links('pagination::bootstrap-5')}}
                </div>
                
            </div>
        </div>
    </div>
    <!-- Table End -->
    <script>
        $(document).ready(function() {
            $('#userReceipts').DataTable({
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
