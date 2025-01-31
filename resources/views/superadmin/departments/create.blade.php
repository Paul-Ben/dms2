@extends('dashboards.index')
@section('content')
    <div>
        <!-- Button Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">

                </div>
            </div>
        </div>
        <!-- Button End -->
        <!-- Form Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-4">Fill All Fields Required</h6>
                            <div>
                                <a class="btn btn-sm btn-primary" href="{{ route('department.index') }}"><i
                                        class="fa fa-arrow-left me-2"></i>Back</a>
                            </div>

                        </div>

                        <form action="{{route('department.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="category" class="form-label">Parent Organisation</label>
                                    <select class="form-select" id="category" name="tenant_id">
                                        <option value="">Select Parent Organisation</option>
                                        @foreach ($organisations as $organisation)
                                            <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="address" class="form-label">Description</label>
                                <textarea class="form-control" id="address" name="description"></textarea>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- Form End -->
    </div>
@endsection
