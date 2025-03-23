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
                <h6 class="mb-0">Memo Management</h6>
                <div>
                    <a class="btn btn-sm btn-primary" href="{{ route('memo.create') }}">Memo</a>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('memo.template') }}">Add Template</a> --}}
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                            class="fa fa-arrow-left me-2"></i>Back</a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="memoIndex" class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Document No</th>
                            <th scope="col">Title</th>
                            {{-- <th scope="col">Uploaded By</th> --}}
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($memos as $key => $document)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{ route('memo.generate', $document) }}" target="__blank">{{ $document->docuent_number }}</a>
                                </td>
                                <td><a href="{{ route('memo.generate', $document)}}" target="__blank">{{ $document->title }}</a></td>
                                {{-- <td></td> --}}
                                <td>{{$document->status}}</td>
                                <td>
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle"
                                            data-bs-toggle="dropdown">Details</a>
                                        <div class="dropdown-menu">
                                            <a href="" onclick="showSendOptions(event)"
                                                class="dropdown-item">Send</a>
                                            <a href="{{route('memo.edit', $document)}}" class="dropdown-item">Edit</a>
                                            {{-- <a href="delete_student.html" class="dropdown-item" style="background-color: rgb(239, 79, 79)">Delete</a> --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td></td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="pt-4">
                    {{ $memos->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    <!-- Pop-up Modal -->
    <div id="sendOptionsModal" class="modal pt-5" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Choose Sending Option</h2>
            <p>Would you like to send the document internally or externally?</p>
            <button onclick="sendDocument('internal')">Send Internally</button><br>
            <button onclick="sendDocument('external')">Send Externally</button>
        </div>
    </div>
    <!-- Table End -->
    <script>
        // Check if $document is null and set a default value or handle accordingly
        @if(isset($document) && $document)
            const documentId = '{{ $document->id }}'; // Use document ID if available
        @else
            const documentId = null; // Set to null or handle as needed
        @endif
    
        function showSendOptions(event) {
            event.preventDefault(); // Prevent the default link behavior
            document.getElementById('sendOptionsModal').style.display = 'block'; // Show the modal
        }
    
        function closeModal() {
            document.getElementById('sendOptionsModal').style.display = 'none'; // Hide the modal
        }
    
        function sendDocument(option) {
            if (!documentId) {
                alert("Memo not found."); // Alert user if document ID is null
                return; // Exit the function early
            }
    
            if (option === 'internal') {
                window.location.href = "{{ route('memo.send', ':id') }}".replace(':id', documentId); // Redirect to internal send route
            } else {
                // Handle external send route here, e.g.:
                window.location.href = "{{route('memo.sendout', ':id')}}".replace(':id', documentId); // Redirect to external send route
            }
        }
    </script>
    
    <style>
        .modal {
            display: flex;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
        }

        .close {
            color: #a31212;
            float: right;
            font-size: 28px;
        }

        .close:hover,
        .close:focus {
            color: rgb(198, 63, 63);
            text-decoration: none;
            cursor: pointer;
        }
    </style>

<script>
    $(document).ready(function() {
        $('#memoIndex').DataTable({
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
