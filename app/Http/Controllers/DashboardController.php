<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\linkPeta;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalPeta = linkPeta::count();

        $data_bs = DB::table('link_peta as lp')
            ->join('history_folder_peta as hf', 'hf.id', '=', 'lp.id_history_folder')
            ->select(
                'lp.bs_lengkap',
                'hf.id_kegiatan',
                'hf.bulan_kegiatan',
                'hf.tahun_kegiatan',
                'hf.versi_bs'
            )
            ->get();

        $result_bs = $data_bs->groupBy('bs_lengkap')->map(function ($items) {
            $versi1 = $items->where('versi_bs', 1)
                ->sortByDesc(fn($i) => $i->tahun_kegiatan * 100 + $i->bulan_kegiatan)
                ->first();
            $versi2 = $items->where('versi_bs', 2)
                ->sortByDesc(fn($i) => $i->tahun_kegiatan * 100 + $i->bulan_kegiatan)
                ->first();

            return [
                'bs_lengkap'    => $items->first()->bs_lengkap,
                'versi1_kode'   => $versi1->id_kegiatan ?? null,
                'versi1_bulan'  => $versi1->bulan_kegiatan ?? null,
                'versi1_tahun'  => $versi1->tahun_kegiatan ?? null,
                'versi2_kode'   => $versi2->id_kegiatan ?? null,
                'versi2_bulan'  => $versi2->bulan_kegiatan ?? null,
                'versi2_tahun'  => $versi2->tahun_kegiatan ?? null,
            ];
        })->values();


        $data_sls = DB::table('link_peta as lp')
            ->join('history_folder_peta as hf', 'hf.id', '=', 'lp.id_history_folder')
            ->select(
                DB::raw("CONCAT('1372', lp.kode_kec, lp.kode_kel) as kode_gabungan"),
                'lp.kode_kec',
                'lp.kode_kel',
                'hf.id_kegiatan',
                'hf.bulan_kegiatan',
                'hf.tahun_kegiatan'
            )
            ->where('lp.kode_jenis', '=', 'WS')
            ->get();

        $result_sls = $data_sls->groupBy('kode_gabungan')->map(function ($items) {
            $latest = $items
                ->sortByDesc(fn($i) => $i->tahun_kegiatan * 100 + $i->bulan_kegiatan)
                ->first();

            return [
                'kode_gabungan' => $items->first()->kode_gabungan,
                'kode_kegiatan' => $latest->id_kegiatan,
                'bulan'         => $latest->bulan_kegiatan,
                'tahun'         => $latest->tahun_kegiatan,
            ];
        })->values();

        // return $result_sls;
        return view('dashboard', compact('totalPeta', 'result_bs', 'result_sls'));
    }
}
