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
                    <form action="{{ route('store.fileCharge') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-xl-6 mb-3">
                                <label class="form-label" for="csv_file">Set File Charge:</label>
                                <input class="form-control" type="text" name="file_charge" id="csv_file"
                                   placeholder="500.00" required>
                                    <label class="form-label" for="csv_file">Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                <br><br>
                                <button type="submit">Set Charge</button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Document Charge</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($fileCharges as $key => $fileCharge)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{$fileCharge->file_charge}}
                                            </td>
                                            <td>{{$fileCharge->status}}</td>
                                            <td>
                                                <div class="nav-item dropdown">
                                                    <a href="#" class="nav-link dropdown-toggle"
                                                        data-bs-toggle="dropdown">Details</a>
                                                    <div class="dropdown-menu">
                                                        <a href="{{route('edit.fileChargeForm', $fileCharge)}}" class="dropdown-item">Edit</a>
                                                        <form action="{{ route('delete.fileCharge', $fileCharge) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                           
                                                            <button class="dropdown-item" style="background-color: rgb(235, 78, 78)" type="submit">Delete</button>
                                                        </form> 
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
