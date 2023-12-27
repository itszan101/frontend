@extends('layouts.app')
@section('title', 'List Client')
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/library/selectric/public/selectric.css') }}">
@endpush
@section('main')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('post') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Halaman Post</h1>
            <div class="section-header-button">
                <a href="{{ route('createPost') }}" class="btn btn-primary">Create Post</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href={{ route('post') }}>Halaman Post</a></div>
                <div class="breadcrumb-item">List CLient</div>
            </div>
        </div>
    </section>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between mr-1 ml-1">
                            <div>
                                <h4>List all Post</h4>
                            </div>

                        </div>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

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

                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No.</th>
                                        <th style="text-align: center">Judul</th>
                                        <th style="text-align: center">Author</th>
                                        <th style="text-align: center">Status</th>
                                        <th style="text-align: center">Created At</th>
                                        <th style="text-align: center">Action</th>
                                        <th style="text-align: center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data as $par => $val)
                                        <tr>
                                            <td style="text-align: center">
                                                {{ $i++ }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $val['title'] }}
                                            </td>

                                            <td style="text-align: center">
                                                <a href="#">
                                                    <img alt="image" src="{{ asset('assets/img/avatar/avatar-5.png') }}"
                                                        class="rounded-circle" width="35" data-toggle="title"
                                                        title="">
                                                    <div class="d-inline-block ml-1">{{ $val['writer']['username'] }}</div>
                                                </a>

                                            </td>

                                            <td style="text-align: center">
                                                <div class="badge badge-success">Aktif</div>
                                            </td>

                                            <td style="text-align: center">
                                                {{ $val['created_at'] }}
                                            </td>
                                            <td style="text-align: center">
                                                <form action="{{ route('destroy') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="id" value="{{ $val['id'] }}"
                                                        required autofocus>
                                                    <button class="btn btn-danger"><i class="fas fa-trash"
                                                            id="swal-6"></i></button>

                                                    <a href="#" target="_blank" class="btn btn-primary"><i
                                                            class="fas fa-eye" id="swal-6"></i></a>
                                                </form>
                                            </td>
                                            <td style="text-align: center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input checkbox-delete"
                                                        id="checkbox-{{ $val['id'] }}" value="{{ $val['id'] }}">
                                                    <label for="checkbox-{{ $val['id'] }}"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="delete-form" action="{{ route('destroy') }}" method="POST">
                                @csrf
                                <div class="float-right">
                                    <button id="delete-selected-btn" class="btn btn-danger" style="display: none;"
                                        type="submit"><i class="fas fa-trash"></i>Delete Selected</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to toggle "Delete Selected" button visibility
            function toggleDeleteButton() {
                if ($('.checkbox-delete:checked').length > 0) {
                    $('#delete-selected-btn').show();
                } else {
                    $('#delete-selected-btn').hide();
                }
            }

            // Event delegation for handling checkbox changes
            $('#table-1').on('change', '.checkbox-delete', function() {
                toggleDeleteButton();
            });

            // Initial setup for checkboxes and button visibility
            toggleDeleteButton();

            $('#delete-form').on('submit', function(e) {
                e.preventDefault();

                var selectedIds = [];
                $('.checkbox-delete:checked').each(function() {
                    selectedIds.push($(this).val()); // Extracting post IDs
                });

                if (selectedIds.length > 0) {
                    // Set the array of IDs in a hidden input before submitting the form
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'ids',
                        value: selectedIds.join(',')
                    }).appendTo('#delete-form');

                    // Submit the form for multiple deletion
                    $(this)[0].submit();
                } else {
                    alert('Please select at least one item to delete.');
                }
            });
        });
    </script>


    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src={{ asset('assets/js/page/modules-datatables.js') }}></script>
    {{-- Insert Custom library below here --}}

    <!-- JS Libraies -->
    <script src="{{ asset('assets/library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-sweetalert.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/features-posts.js') }}"></script>
@endpush
