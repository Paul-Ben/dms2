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
                                @if (session('errors'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa fa-exclamation-circle me-2"></i>{{ session('errors') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>

                                    </div>
                                    
                                @endif
                                <a class="btn btn-sm btn-primary" href="{{ route('organisation.index') }}"><i
                                        class="fa fa-arrow-left me-2"></i>Back</a>
                            </div>

                        </div>

                        <form action="{{ route('organisation.update', $tenant) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" value="{{ $tenant->name }}" class="form-control" id="name"
                                        name="name" required>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" value="{{ $tenant->code }}" class="form-control" id="code"
                                        name="code" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" value="{{ $tenant->email }}" class="form-control" id="email"
                                        name="email" required>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" value="{{ $tenant->phone }}" class="form-control" id="phone"
                                        name="phone">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="{{ $tenant->category }}">{{ $tenant->category }}</option>
                                        <option value="Ministry">Ministry</option>
                                        <option value="Agency">Agency</option>
                                        <option value="Institution">Institution</option>
                                        <option value="Citizen">Citizen</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="{{ $tenant->status }}">{{ $tenant->status }}</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="status" class="form-label">Logo</label>
                                    <input type="file" value="{{$tenant->logo}}" class="form-control" name="logo" id="logo" accept="image/*">
                                    <img class="mt-2" src="{{ asset('logos/' . $tenant->logo) }}" alt="" width="50">
                                </div>

                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address">{{ $tenant->address }}</textarea>
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
