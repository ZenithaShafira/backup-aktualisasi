<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jenis;
use App\Models\linkPeta;
use Illuminate\Support\Facades\Response;

class PencarianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jenis = jenis::all();

        return view('pencarian', compact('jenis'));
    }

    public function searchPeta(Request $request) 
    {
        $jenis = $request->input('jenis_peta');
        $keyword = $request->input('keyword');
        $keywords = explode(' ', $keyword);

        // $result = linkPeta::with('history_folder_peta')
        //     ->where('kode_jenis', $jenis)
        //     ->where(function ($query) use ($keyword) {
        //         $query->where('nama_file', 'like', "%{$keyword}%")
        //             ->orWhere('nama_kel', 'like', "%{$keyword}%")
        //             ->orWhere('nama_kec', 'like', "%{$keyword}%")
        //             ->orWhere('nama_sls', 'like', "%{$keyword}%")
        //             ->orWhere('nama_kegiatan', 'like', "%{$keyword}%")
        //             ->orWhere('tahun_kegiatan', 'like', "%{$keyword}%")
        //             ->orWhere('kode_kegiatan', 'like', "%{$keyword}%");
        //     })
        $result = linkPeta::with('history_folder_peta')
            ->where('kode_jenis', $jenis)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->where(function ($q) use ($word) {
                        $q->where('nama_file', 'like', "%{$word}%")
                        ->orWhere('nama_kel', 'like', "%{$word}%")
                        ->orWhere('nama_kec', 'like', "%{$word}%")
                        ->orWhere('nama_sls', 'like', "%{$word}%")
                        ->orWhere('nama_kegiatan', 'like', "%{$word}%")
                        ->orWhere('tahun_kegiatan', 'like', "%{$word}%")
                        ->orWhere('kode_kegiatan', 'like', "%{$word}%");
                    });
                }
            })
            ->get(['id', 'nama_file', 'link_file', 'nama_kec', 'nama_kel', 'nama_sls', 'nama_kegiatan', 'kode_kegiatan', 'id_history_folder']) 
            ->sortByDesc(function ($item) {
                $bulan = (int) optional($item->history_folder_peta)->bulan_kegiatan ?? 0;
                $tahun = (int) optional($item->history_folder_peta)->tahun_kegiatan ?? 0;
                return $tahun * 100 + $bulan; 
            })
            ->groupBy(function ($item) {
                $bulan = (int) optional($item->history_folder_peta)->bulan_kegiatan;
                $tahun = optional($item->history_folder_peta)->tahun_kegiatan ?? 'null';
                $nama_kegiatan = $item->nama_kegiatan ?? '-';
                $kode_kegiatan = $item->kode_kegiatan ?? '-';

                $bulanNama = match($bulan) {
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
                    default => 'Tidak diketahui'
                };
                return "({$kode_kegiatan}-{$tahun}) {$nama_kegiatan} {$bulanNama} {$tahun}";
            });
 
        $formatted = $result->map(function ($group) {
            return $group->map(function ($item) {
                return [
                    'nama_kec' => $item->nama_kec,
                    'nama_kel' => $item->nama_kel,
                    'nama_sls' => $item->nama_sls,
                    'nama_file' => $item->nama_file,
                    'link_file' => $item->link_file,
                ];
            });
        });
        

        return Response::json($formatted);
    }
}
