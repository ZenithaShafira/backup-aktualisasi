@extends('layouts.app')

@section('title', 'Edit Peta')

@push('style')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Peta</h1>
        </div>

            <!-- row 1  -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pilih Peta</h4>
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
                        @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        <form id="editPeta" method="POST" action="/edit-peta/submit">
                            @csrf
                            <div class="row">            
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jenis_peta">Jenis Peta</label>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kegiatan_id">Kegiatan</label>
                                        <select 
                                            id="kegiatan_id"
                                            name="kegiatan_id"
                                            class="form-control @error('kegiatan_id') is-invalid @enderror"
                                            required>
                                            <option value="" disabled>Pilih Kegiatan</option>
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
                                            <option value="" disabled>Pilih Bulan</option>
                                        </select>
                                        @error('bulan_kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tahun_kegiatan">Tahun Kegiatan</label>
                                        <select 
                                            id="tahun_kegiatan"
                                            name="tahun_kegiatan"
                                            class="form-control @error('tahun_kegiatan') is-invalid @enderror"
                                            required>
                                            <option value="" disabled>Pilih Tahun</option>
                                        </select>

                                        @error('tahun_kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-11">
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

                                <div class="col-md-1 d-flex align-items-center justify-content-center">
                                    <!-- <div class="form-group text-center"> -->
                                        <button class="btn btn-primary"
                                            type="Button"
                                            id="editButton"
                                            name="editButton">
                                            Edit
                                        </button>
                                    <!-- </div> -->
                                </div>
                            </div>


                            <input type="hidden" id="history_id" name="history_id">
                            <input type="hidden" id="hasilPrev" name="hasilPrev">

                            <div class="text-right">
                                <button class="btn btn-primary"
                                    type="button"
                                    id="prevEditButton"
                                    name="prevEditButton">
                                    Preview Link
                                </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="loadingText" class="mt-2" style="display: none; justify-content: center;">Sedang Memuat....</div>

        <div class="row" id="prevBaruCard">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Preview Link File Peta (Terbaru)</h4>
                    </div>
                    
                    <div class="card-body" id="prevBaruBody">
                        <div class="table-responsive">
                            <table class="table-striped table" id="prevBaruTabel" style="width: 100%;">
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

                            <div class="text-right mt-5">
                                <button class="btn btn-primary"
                                    type="submit"
                                    id="submitEditPeta"
                                    name="submitEditPeta">
                                    Submit Perubahan Peta
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

    <script src="{{ asset('js/page/edit-peta.js') }}"></script>

@endpush
