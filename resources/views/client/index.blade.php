@extends('layouts.app')
@section('title', 'List Client')
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap4.min.css">
@endpush
@section('main')
<section class="section">
    <div class="section-header">
        <h1>Domain AWH</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href={{ route('client') }}>Domain AWH</a></div>
            <div class="breadcrumb-item">List CLient</div>
        </div>
    </div>
</section>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between mr-1 ml-1" >
                            <div>
                                <h4>List Web Instan</h4>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Masukan Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="domain">Nama Website</label>
                                            <input type="text" class="form-control" id="domain"
                                                aria-describedby="emailHelp" name="domain" placeholder="Initest">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" onclick="tambahclient()" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">#</th>
                                        <th>Nama</th>
                                        <th style="text-align: center">Status</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data as $par => $val)
                                        <tr>
                                            <td style="text-align: center">
                                                {{ $par += 1 }}
                                            </td>
                                            <td>{{ $val['title'] }}</td>
                                            <td style="text-align: center">
                                                <div class="badge badge-success">Ready</div>
                                            </td>
                                            <td style="text-align: center">
                                                <button onclick="hapusclient({{ $val['id'] }})"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                <a href="#"
                                                    target="_blank" class="btn btn-primary"><i class="fas fa-eye"></i></a>
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
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src={{ asset('assets/js/page/modules-datatables.js') }}></script>
    {{-- Insert Custom library below here --}}
    <script>
        // get data by element id
        function getid(id) {
            return $('#' + id).val()
        }
        async function hapusclient(id) {
            const tg = await swshow(true, 'warning', 'Hapus?'); // Tampilkan swal promt
            if (tg) {
                showloading() // Tampilkan swal loading
                const t = await del('domain/' + id) // endpoint request axios
                const r = await hideloading(t.success) // tunggu hingga ada balasan
                if (r) { // swal alert otomatis mengecek berhasil atau gagal
                    window.location.reload() // klik ok pada swal alert
                }
            }
        }
        async function tambahclient() {
            showloading() // Tampilkan swal loading
            formdata = new FormData() // init formdata
            formdata.append('domain', getid('domain'))
            const t = await post('domain', formdata) // endpoint request axios
            const r = await hideloading(t.success) // tunggu hingga ada balasan
            if (r) { // swal alert otomatis mengecek berhasil atau gagal
                window.location.reload() // klik ok pada swal alert
            }
        }
    </script>
@endpush
