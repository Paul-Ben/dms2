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
                <h6 class="mb-0">Visitor Activity</h6>
                <div>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('visitor.activity.create') }}"><i class="fa fa-plus me-2"></i>Add Visitor Activity</a> --}}
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                            class="fa fa-arrow-left me-2"></i>Back</a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="visitorActivityTable" class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Visitor Name</th>
                            <th scope="col">Ip Address</th>
                            <th scope="col">URL</th>
                            <th scope="col">Browser</th>
                            <th scope="col">Device</th>
                            {{-- <th scope="col">Country</th> --}}
                            {{-- <th scope="col">Region</th>
                            <th scope="col">City</th>
                            <th scope="col">Method</th> --}}
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $key => $activity)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $activity->user ? $activity->user->name : 'Guest' }}</td>
                                <td>{{ $activity->ip_address }}</td>
                                <td>{{ $activity->url ?? 'N/A' }}</td>
                                <td>{{ $activity->browser }}</td>
                                <td>{{ $activity->device ?? 'N/A' }}</td>
                                {{-- <td>{{ $activity->country ?? 'N/A' }}</td> --}}
                                {{-- <td>{{ $activity->region ?? 'N/A' }}</td>
                                <td>{{ $activity->city ?? 'N/A' }}</td>
                                <td>{{ $activity->method ?? 'N/A' }}</td> --}}
                                <td>{{ $activity->created_at->format('M j, Y g:i A') }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="6">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- {{ $activities->links() }} --}}
            </div>
        </div>
    </div>
    <!-- Table End -->
    <script>
        $(document).ready(function() {
            $('#visitorActivityTable').DataTable({
                "order": [
                    [0, "desc"]
                ], // Optional: order by latest
                "pageLength": 10
            });
        });
    </script>
@endsection
