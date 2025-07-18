@extends('layouts.app')

@section('title', 'Input Peta')

@push('style')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Input Peta</h1>
        </div>

        <!-- row 2  -->
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

                        <form id="tambahKegiatan" method="POST" action="/input-kegiatan">
                            @csrf
                            <div class="row">            
                                <!-- <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Kegiatan</label>
                                        <input 
                                            id="nama"
                                            type="text" 
                                            class="form-control @error('nama') is-invalid @enderror"
                                            name="nama"
                                            value="{{ old('nama') }}"
                                            autofocus
                                            required>

                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="kegiatan_id">Kegiatan</label>
                                        <select 
                                            id="kegiatan_id"
                                            name="kegiatan_id"
                                            class="form-control @error('kegiatan_id') is-invalid @enderror select2"
                                            required>
                                            <option value="" disabled selected>-- Pilih Kegiatan --</option>
                                            @foreach($kegiatan as $item)
                                                <option value="{{ $item->id }}">
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

                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="kode">Tahun Kegiatan</label>
                                        <input 
                                            id="kode"
                                            type="text"
                                            name="kode"
                                            value="{{ old('kode') }}"
                                            class="form-control  @error('kode') is-invalid @enderror">
                                        
                                        @error('kode')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2010;
                                    $endYear = $currentYear + 5;
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

<!-- 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Jenis Peta</label>
                                        <input 
                                            id="nama"
                                            type="text" 
                                            class="form-control @error('nama') is-invalid @enderror"
                                            name="nama"
                                            value="{{ old('nama') }}"
                                            autofocus
                                            required>

                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jenis_peta">Jenis Peta</label>
                                        <select 
                                            id="jenis_peta"
                                            name="jenis_peta"
                                            class="form-control @error('jenis_peta') is-invalid @enderror select2"
                                            required>
                                            <option value="" disabled selected>-- Pilih Jenis Peta --</option>
                                            @foreach($jenis as $item)
                                                <option value="{{ $item->jenis_peta }}">
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

                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="kode">Versi Peta</label>
                                        <input 
                                            id="kode"
                                            type="text"
                                            name="kode"
                                            value="{{ old('kode') }}"
                                            class="form-control  @error('kode') is-invalid @enderror">
                                        
                                        @error('kode')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="versi">Versi Peta</label>
                                        <select 
                                            id="versi"
                                            name="versi"
                                            class="form-control @error('versi') is-invalid @enderror select2"
                                            required>
                                            <option value="" disabled selected>-- Pilih Versi Peta --</option>
                                            @foreach($jenis as $item)
                                                <option value="{{ $item->id }}">
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
                                        <label for="">Link Folder</label>
                                        <input 
                                            id="link_folder"
                                            type="text" 
                                            class="form-control @error('link_fol') is-invalid @enderror"
                                            name="nama"
                                            value="{{ old('nama') }}"
                                            autofocus
                                            required>

                                        @error('nama')
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
                                    Preview
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
                        <h4>(preview tabel link)</h4>
   
                    <div class="card-body">
                        <!-- ISI TABEL -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <script src="{{ asset('js/page/input-peta.js') }}"></script>
@endpush
