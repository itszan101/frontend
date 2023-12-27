@extends('layouts.app')

@section('title', 'Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')

    <section class="section">
        <div class="section-header">
            <h1>Account Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{ $data['firstname'] }}</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>
            <div class="col-12">
                <div class="card">
                    <form method="post" class="needs-validation" novalidate="">
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-7">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" value="{{ $data['firstname'] }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-7">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" value="{{ $data['lastname'] }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the last name
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-7">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $data['email'] }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the email
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
