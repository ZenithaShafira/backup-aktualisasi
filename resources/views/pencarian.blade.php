@extends('layouts.app')

@section('title', 'Pencarian Peta')

@push('style')

@endpush

@section('content')
    <section class="section">
        <!-- <div class="section-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <h1 class="mb-3">Pencarian Peta</h1> 
                    </div>     
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <form id="searchForm" method="GET" action="" class="form-inline">
                        <div class="form-group mr-2 mb-2 mb-sm-0">
                            <select class="form-control" name="kategori" id="kategori">
                                <option value="">Pilih Kategori</option>
                                <option value="kegiatan">Kegiatan</option>
                                <option value="jenis">Jenis Peta</option>
                            </select>
                        </div>

                        <div class="form-group mr-2 mb-2 mb-sm-0">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Cari..." disabled>
                        </div>

                        <button type="submit" class="btn btn-primary" id="btnCari" disabled>Cari</button>
                    </form>    
                </div>
            </div>
            
        </div> -->

        <!-- row 2  -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="section-header">
                        <h1>Hasil Pencarian</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
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
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- JS Libraies -->

@endpush
