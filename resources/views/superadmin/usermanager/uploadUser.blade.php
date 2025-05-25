@extends('dashboards.index')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded  p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-4">Fill All Fields Required</h6>
                        <div>
                            <a class="btn btn-sm btn-primary" href="{{ route('users.index') }}"><i
                                    class="fa fa-arrow-left me-2"></i>Back</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ asset('templates/Template_sample.csv') }}" class="btn btn-success" download>
                            <i class="fa fa-download"></i> Download CSV Template
                        </a>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted">User Upload Instructions:</p>
                        <ul>
                            <li>Download the template above and use to maintain the correct structure.</li>
                            <li>Ensure the CSV file is formatted correctly.</li>
                            <li>Do not include any headers in the CSV file.</li>
                            <li>Use the correct headers as per the template.</li>
                            <li>Ensure that the Organisation (Tenant) and Departments exist in the system.</li>
                            <li>Check for any duplicate emails to avoid conflicts.</li>
                        </ul>
                    </div>
                    <form action="{{ route('userUpload.csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-xl-6 mb-3">
                                <label class="form-label" for="csv_file">Choose CSV File:</label>
                                <input class="form-control" type="file" name="csv_file" id="csv_file" accept=".csv"
                                    required>
                                <br><br>
                                <button type="submit">Upload</button>
                            </div>
                        </div>
                    </form>

                    @if (session('success'))
                        <div style="color: green;">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div style="color: red;">{{ session('error') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
