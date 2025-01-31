@extends('dashboards.index')
@section('content')
    <link rel="stylesheet" href="{{ asset('dbf/css/custom.css') }}">
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

    <div class="container py-4">
        <h4 class="h4 text-center mb-4">Document Tracking System</h4>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Document Details</h2>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="fw-bold text-muted">Document ID:</div>
                        <div>{{ $document->docuent_number }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="fw-bold text-muted">Title:</div>
                        <div>{{ $document->title }}</div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="fw-bold text-muted">Current Location:</div>
                        <div id="currentLocation">{{$document_locations->last()->recipient->userDetail->tenant_department}}</div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 mb-3">Movement Timeline</h3>
                        <div class="timeline">
                            <div class="col-12">
                                <div class="bg-light rounded h-100 p-4">
                                    {{-- <h6 class="mb-4">Responsive Table</h6> --}}
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">From</th>
                                                    <th scope="col">To</th>
                                                   <th scope="col">Date</th>
                                                   <th scope="col">Location</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($document_locations as $key => $location)
                                                    <tr>
                                                        <th scope="row">{{ $key + 1 }}</th>
                                                        <td>{{ $location->sender->userDetail->designation }}</td>
                                                        <td>{{ $location->recipient->userDetail->designation }}</td>
                                                        <td>{{$location->updated_at->format('M j, Y g:i A')}}</td>
                                                        <td>
                                                            {{$location->recipient->userDetail->tenant_department->name ?? $location->recipient->userDetail->designation}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
