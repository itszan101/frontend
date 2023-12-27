@extends('layouts.app')

@section('title', 'Tambah CLient')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')

    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('post') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create Post</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('post') }}">Post</a></div>
                <div class="breadcrumb-item">Create Post</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Create New Post</h2>
            <p class="section-lead">
                On this page you can create a new post and fill in all fields.
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Write Your Post</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('store') }}" class="needs-validation">
                                @csrf
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
                                <!-- Rest of your form -->

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="title" tabindex="1" required
                                            autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your title post
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea class="summernote-simple" name="news_content" tabindex="1" required autofocus></textarea>
                                        <div class="invalid-feedback">
                                            Please fill in your content
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button type="submit" class="btn btn-primary">Create Post</button>
                                    </div>
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
    <script src="{{ asset('assets/library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/library/upload-preview/upload-preview.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/features-post-create.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-sweetalert.js') }}"></script>
@endpush
