@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')

@endpush

@section('content')
    <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <!-- row 1 statistik -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Peta</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPeta }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="https://drive.google.com/drive/folders/1PySKiSy-I-yHb--0lVZBWef_iOHjJORX?usp=sharing" target="_blank" style="text-decoration: none; color: inherit;">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="card-wrap d-flex align-items-center justify-content-start pr-2" style="height: 100px;">
                            <div class="card-body p-0">
                                <h4 class="m-0" style="font-size: 16px;">Peta WS Terbaru (2024)</h4>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="https://drive.google.com/drive/folders/1OlH2Ni1e2XsnWA_YuDGL3ycqxZyNe0sW?usp=sharing" target="_blank" style="text-decoration: none; color: inherit;">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-map-marked"></i>
                        </div>
                        <div class="card-wrap d-flex align-items-center justify-content-start pr-2" style="height: 100px;">
                            <div class="card-body p-0">
                                <h4 class="m-0" style="font-size: 16px;">Peta WB Terbaru (2024)</h4>
                            </div>
                        </div>
                    </div>
                    </a>        
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="https://drive.google.com/drive/folders/18Is2QEpOabjjugt1CxcZbc0rdInn7cKp?usp=drive_link" target="_blank" style="text-decoration: none; color: inherit;">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-map"></i>
                        </div>
                        <div class="card-wrap d-flex align-items-center justify-content-start pr-2" style="height: 100px;">
                            <div class="card-body p-0">
                                <h4 class="m-0" style="font-size: 16px;">Template Peta Terbaru (2024)</h4>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>

            <!-- row 2  -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kondisi Terbaru Peta Blok Sensus (WB)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="wbTabel" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Blok Sensus</th>
                                            <th>BS-2020</th>
                                            <th>BS-2010</th>
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

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kondisi Terbaru Peta SLS (WS)</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="wsTabel" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Nama SLS</th>
                                            <th>SLS</th>
                                            <th>Kegiatan</th>
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
    <script src="{{ asset('js/page/dashboard.js') }}"></script>
@endpush
