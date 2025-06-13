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
                <h6 class="mb-0">Visitor Activity Backup</h6>
                <div>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('visitor.activity.create') }}"><i class="fa fa-plus me-2"></i>Add Visitor Activity</a> --}}
                    <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}"><i
                            class="fa fa-arrow-left me-2"></i>Back</a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="BackupsTable" class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Backup Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($backups as $key => $backup)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>Backup {{ $backup->created_at }}</td>
                                <td>{{ $backup->created_at }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('backup.download', $backup) }}"
                                        class="btn btn-sm btn-primary">
                                        Download
                                    </a>
                                    <form action="{{ route('backup.delete', $backup )}}" method="POST">
                                        @csrf
                                        @method('Delete')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        Delete
                                    </button>
                                    </form>
                                    </div>
                                    
                                    
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
                                <td>No Data Found</td>
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
            $('#BackupsTable').DataTable({
                "order": [
                    [0, "desc"]
                ], // Optional: order by latest
                "pageLength": 10
            });
        });
    </script>
@endsection
