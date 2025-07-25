<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\linkPeta;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalPeta = linkPeta::count();
        // return $result_sls;
        return view('dashboard', compact('totalPeta'));
    }

    public function getKondisiWB() {
        $singkatanBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Ags',
            9 => 'Sept',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $data_bs = DB::table('link_peta as lp')
            ->join('history_folder_peta as hf', 'hf.id', '=', 'lp.id_history_folder')
            ->select(
                'lp.nama_kec',
                'lp.nama_kel',
                'lp.bs_lengkap',
                'hf.id_kegiatan',
                'hf.bulan_kegiatan',
                'hf.tahun_kegiatan',
                'hf.versi_bs'
            )
            ->get();

        $result_bs = $data_bs->groupBy('bs_lengkap')->map(function ($items) use ($singkatanBulan) {
            $versi1 = $items->where('versi_bs', 1)
                ->sortByDesc(fn($i) => $i->tahun_kegiatan * 100 + $i->bulan_kegiatan)
                ->first();
            $versi2 = $items->where('versi_bs', 2)
                ->sortByDesc(fn($i) => $i->tahun_kegiatan * 100 + $i->bulan_kegiatan)
                ->first();

            return [
                'nama_kecamatan' => $items->first()->nama_kec,
                'nama_kelurahan' => $items->first()->nama_kel,
                'bs_lengkap'    => $items->first()->bs_lengkap,
                'bs_2020' => $versi1
                                ? trim(($versi1->id_kegiatan ?? '') . ' ' .
                                    (!is_null($versi1->bulan_kegiatan)
                                            ? ($singkatanBulan[$versi1->bulan_kegiatan] ?? '-')
                                            : '') . ' ' .
                                    ($versi1->tahun_kegiatan ?? ''))
                                : "-",
                'bs_2010' => $versi2
                                ? trim(($versi2->id_kegiatan ?? '') . ' ' .
                                    (!is_null($versi2->bulan_kegiatan)
                                            ? ($singkatanBulan[$versi2->bulan_kegiatan] ?? '-')
                                            : '') . ' ' .
                                    ($versi2->tahun_kegiatan ?? ''))
                                : "-",
            ];
        })->sortBy('bs_lengkap')->values();

        return DataTables::of($result_bs)->make(true);
    }

    public function getKondisiWS() {
        $singkatanBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Ags',
            9 => 'Sept',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

         $data_sls = DB::table('link_peta as lp')
            ->join('history_folder_peta as hf', 'hf.id', '=', 'lp.id_history_folder')
            ->select(
                'lp.nama_kec',
                'lp.nama_kel',
                'lp.sls_lengkap',
                'lp.nama_sls',
                'hf.id_kegiatan',
                'hf.bulan_kegiatan',
                'hf.tahun_kegiatan'
            )
            ->get();

        $result_sls = $data_sls->groupBy('sls_lengkap')->map(function ($items) use ($singkatanBulan) {
            $latest = $items
                ->sortByDesc(fn($i) => $i->tahun_kegiatan * 100 + $i->bulan_kegiatan)
                ->first();

            return [
                'nama_kecamatan' => $items->first()->nama_kec,
                'nama_kelurahan' => $items->first()->nama_kel,
                'sls_lengkap'   => $items->first()->sls_lengkap,
                'nama_sls'      => $items->first()->nama_sls,
                'kegiatan'      => $latest
                                ? trim(($latest->id_kegiatan ?? '') . ' ' .
                                    (!is_null($latest->bulan_kegiatan)
                                            ? ($singkatanBulan[$latest->bulan_kegiatan] ?? '-')
                                            : '') . ' ' .
                                    ($latest->tahun_kegiatan ?? ''))
                                : "-",
                // 'kode_kegiatan' => $latest->id_kegiatan,
                // 'bulan'         => $latest && !is_null($latest->bulan_kegiatan)
                //                     ? ($singkatanBulan[$latest->bulan_kegiatan] ?? '-')
                //                     : null,
                // 'tahun'         => $latest->tahun_kegiatan,
            ];
        })->sortBy('sls_lengkap')->values();

        return DataTables::of($result_sls)->make(true);
    }
}
