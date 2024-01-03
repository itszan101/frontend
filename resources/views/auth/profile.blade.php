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
                <div class="breadcrumb-item active"><a href="#">Profile</a></div>
                <div class="breadcrumb-item">Account Settings</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{ $data['firstname'] }}</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('updateProfile') }}" class="needs-validation">
                                @csrf

                                <div class="form-group col-sm-12 col-md-7">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $data['email'] }}"
                                        required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-7">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username"
                                        value="{{ $data['username'] }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-7">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="firstname"
                                        value="{{ $data['firstname'] }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-7">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lastname"
                                        value="{{ $data['lastname'] }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the last name
                                    </div>
                                    <div class="card-footer text-left">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <form>
                            <div class="card-header">
                                <h4>Change Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" class="form-control is-valid" value="Rizal Fakhri" required="">
                                    <div class="valid-feedback">
                                        Good job!
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control is-invalid" required=""
                                        value="rizal@fakhri">
                                    <div class="invalid-feedback">
                                        Oh no! Password not match.
                                    </div>
                                </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
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
