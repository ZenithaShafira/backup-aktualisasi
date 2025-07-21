@extends('layouts.app')

@section('title', 'Input Kegiatan')

@push('style')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Input Kegiatan</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Kegiatan</h4>
                    </div>

                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close"
                                        data-dismiss="alert">
                                            <span>&times;</span>
                                    </button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <form id="tambahKegiatan" method="GET" action="/input-kegiatan">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">Nama Kegiatan</label>
                                        <input 
                                            id="nama_kegiatan"
                                            type="text" 
                                            class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                            name="nama_kegiatan"
                                            value="{{ old('nama_kegiatan') }}"
                                            autofocus
                                            required>

                                        @error('nama_kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kode_kegiatan">Kode Kegiatan</label>
                                        <input 
                                            id="kode_kegiatan"
                                            type="text"
                                            name="kode_kegiatan"
                                            value="{{ old('kode_kegiatan') }}"
                                            class="form-control  @error('kode_kegiatan') is-invalid @enderror">
                                        
                                        @error('kode_kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button class="btn btn-primary"
                                    type="submit"
                                    id="submitKegiatan">
                                    Tambah Kegiatan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>  
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Kegiatan yang Telah Terdaftar</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="kegiatanTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Kegiatan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>                      
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/input-kegiatan.js') }}"></script>
@endpush
