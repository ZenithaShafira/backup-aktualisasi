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
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
                </div>
            </div>

            <!-- row 2  -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kondisi Terbaru Peta</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#"
                                        class="btn btn-primary">SLS</a>
                                    <a href="#"
                                        class="btn">BS</a>
                                </div>
                            </div>
                        </div>
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

@endpush
