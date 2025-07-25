@extends('layouts.app')

@section('title', 'Pencarian Peta')

@push('style')

@endpush

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="section-header mb-2">
                        <h1>Peta Apa yang Anda Butuhkan?</h1>
                    </div>
                    <div class="card-body">
                        <form id="cariPeta" action="/pencarian-peta/cari" method="GET">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select 
                                            id="jenis_peta"
                                            name="jenis_peta"
                                            class="form-control @error('jenis_peta') is-invalid @enderror"
                                            required>
                                            <option value="" disabled {{ old('jenis_peta') ? '' : 'selected' }}>Pilih Jenis</option>
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

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input 
                                            id="keyword"
                                            type="text" 
                                            class="form-control @error('keyword') is-invalid @enderror"
                                            name="keyword"
                                            value="{{ old('keyword') }}"
                                            placeholder="13720100001001B, Tanah Garam, Lubuk Sikarah ....."
                                            required>

                                        @error('keyword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- <div class="col-md-2"> -->
                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block w-100 h-100" type="submit" id="tombolSearch">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                                <!-- </div> -->
                        
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="loadingText" class="mt-2" style="display: none; justify-content: center;">Sedang Memuat....</div>
        <div class="card" style="display: none;" id="errorContainer">
            <div class="card-header">
                <h4>Hasil Pencarian</h4>
            </div>
            <div class="card-body">
                <div id="statusText" class="mt-2"></div>
            </div>
        </div>
        <div class="row" id="hasilContainer"></div>
        
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

    <script src="{{ asset('js/page/hasil-pencarian.js') }}"></script>
@endpush
