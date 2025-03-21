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
                    <form action="{{ route('update.fileCharge', $fileCharge) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-sm-12 col-xl-6 mb-3">
                                <label class="form-label" for="csv_file">Set File Charge:</label>
                                <input class="form-control" type="text" name="file_charge" id="csv_file"
                                   value="{{$fileCharge->file_charge}}" required>
                                    <label class="form-label" for="csv_file">Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="{{$fileCharge->status}}">{{$fileCharge->status}}</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                <br><br>
                                <button type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
