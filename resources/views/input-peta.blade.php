@extends('layouts.app')

@section('title', 'Input Peta')

@push('style')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Input Peta</h1>
        </div>

        <!-- row 1  -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Peta</h4>
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

                        <form id="prevPeta" method="POST" action="/input-peta/preview">
                            @csrf
                            <div class="row">            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kegiatan_id">Kegiatan</label>
                                        <select 
                                            id="kegiatan_id"
                                            name="kegiatan_id"
                                            class="form-control @error('kegiatan_id') is-invalid @enderror"
                                            required>
                                            <option value="" disabled {{ old('kegiatan_id') ? '' : 'selected' }}>Pilih Kegiatan</option>
                                            @foreach($kegiatan as $item)
                                                <option value="{{ $item->kode_kegiatan }}" {{ old('kegiatan_id') == $item->kode_kegiatan ? 'selected' : '' }}>
                                                    ({{ $item->kode_kegiatan }}) {{ $item->nama_kegiatan }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('kegiatan_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bulan_kegiatan">Bulan Kegiatan</label>
                                        <select 
                                            id="bulan_kegiatan"
                                            name="bulan_kegiatan"
                                            class="form-control @error('bulan_kegiatan') is-invalid @enderror"
                                            required>
                                            <option value="" disabled {{ old('bulan_kegiatan') ? '' : 'selected' }}>Pilih Bulan</option>
                                            @php
                                                $bulanIndo = [
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'Oktober',
                                                    11 => 'November',
                                                    12 => 'Desember',
                                                ];
                                            @endphp
                                            @foreach($bulanIndo as $key => $label)
                                                <option value="{{ $key }}" {{ old('bulan_kegiatan') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('bulan_kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2010;
                                    $endYear = $currentYear + 2;
                                @endphp

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tahun_kegiatan">Tahun Kegiatan</label>
                                        <select 
                                            id="tahun_kegiatan"
                                            name="tahun_kegiatan"
                                            class="form-control @error('tahun_kegiatan') is-invalid @enderror"
                                            required>
                                            <option value="" disabled {{ old('tahun_kegiatan') ? '' : 'selected' }}>-- Pilih Tahun --</option>
                                            @for($year = $endYear; $year >= $startYear; $year--)
                                                <option value="{{ $year }}" {{ old('tahun_kegiatan') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>

                                        @error('tahun_kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jenis_peta">Jenis Peta</label>
                                        <select 
                                            id="jenis_peta"
                                            name="jenis_peta"
                                            class="form-control @error('jenis_peta') is-invalid @enderror"
                                            required>
                                            <option value="" disabled {{ old('jenis_peta') ? '' : 'selected' }}>Pilih Jenis Peta</option>
                                            @foreach($jenis as $item)
                                                <option value="{{ $item->jenis_peta }}" {{ old('jenis_peta') == $item->jenis_peta ? 'selected' : '' }}>
                                                    {{ $item->jenis_peta }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('jenis_peta')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="versi">Versi BS</label>
                                        <select 
                                            id="versi"
                                            name="versi"
                                            class="form-control @error('versi') is-invalid @enderror"
                                            disabled>
                                            <option value="" disabled selected>Pilih Versi BS</option>
                                            @foreach($versi as $item)
                                                <option value="{{ $item->id }}" {{ old('versi') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->versi }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('versi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="folder_url">Link Folder</label>
                                        <input 
                                            id="folder_url"
                                            type="text" 
                                            class="form-control @error('folder_url') is-invalid @enderror"
                                            name="folder_url"
                                            value="{{ old('folder_url') }}"
                                            required>

                                        @error('folder_url')
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
                                    id="showTabelPreview">
                                    Tampilkan Preview
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- row 2  -->
        <div class="row" id="prevCard" style="display:none;">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Preview Link File Peta</h4>
                    </div>
                    
                    <div class="card-body" id="prevBody">
                        <div class="table-responsive">
                            <table class="table-striped table" id="prevTabel" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nama File</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>                      
                            </table>
                        </div>

                        <form id="storePeta" action="/input-peta/store" method="POST">
                            @csrf
                            <input type="hidden" id="store_kegiatan_id" name="store_kegiatan_id">
                            <input type="hidden" id="store_tahun" name="store_tahun">
                            <input type="hidden" id="store_bulan" name="store_bulan">
                            <input type="hidden" id="store_jenis" name="store_jenis">
                            <input type="hidden" id="store_versi" name="store_versi">
                            <input type="hidden" id="store_link" name="store_link">
                            <input type="hidden" id="store_peta" name="store_peta">
                            <div class="text-right mt-5">
                                <button class="btn btn-primary"
                                    type="submit"
                                    id="simpanPeta"
                                    name="simpanPeta">
                                    Simpan Peta
                                </button>
                            </div>
                        </form>
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

    <script src="{{ asset('js/page/input-peta.js') }}"></script>
@endpush
