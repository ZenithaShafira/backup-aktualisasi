<?php

namespace App\Http\Controllers;

use App\Models\historyFolderPeta;
use App\Models\linkPeta;
use App\Models\jenis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditPetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jenis = jenis::all();
        return view('edit-peta', compact('jenis'));
    }


    public function getKegiatan($jenis_peta)
    {
        $data = historyFolderPeta::with(['kegiatan' => function ($query) {
                $query->select('kode_kegiatan', 'nama_kegiatan');
            }])
            ->where('jenis_peta', $jenis_peta)
            ->get();

        $kegiatan = $data->map(fn($item) => $item->kegiatan)
                        ->filter()
                        ->unique('kode_kegiatan')
                        ->values();

        return response()->json($kegiatan);
        // return $kegiatan;
    }

    public function getBulan($jenis_peta, $kode_kegiatan)
    {
        $namaBulan = [
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

        $data = historyFolderPeta::select('bulan_kegiatan', 'id_kegiatan')
            ->where('jenis_peta', $jenis_peta)
            ->where('id_kegiatan', $kode_kegiatan)
            ->orderBy('bulan_kegiatan', 'asc')
            ->get()
            ->map(function ($item) use ($namaBulan) {
                $item->nama_bulan = $namaBulan[(int) $item->bulan_kegiatan] ?? '-';
                return $item;
            })
            ->unique('bulan_kegiatan') 
            ->values();

        return response()->json($data);
    }

    public function getTahun($jenis_peta, $kode_kegiatan, $bulan_kegiatan)
    {
        $data = historyFolderPeta::select('tahun_kegiatan')
            ->where('jenis_peta', $jenis_peta)
            ->where('id_kegiatan', $kode_kegiatan)
            ->where('bulan_kegiatan', $bulan_kegiatan)
            ->get();

        return response()->json($data);
    }

    public function getLink($jenis_peta, $kode_kegiatan, $bulan_kegiatan, $tahun_kegiatan)
    {
        $data = historyFolderPeta::select('id', 'link_folder')
            ->where('jenis_peta', $jenis_peta)
            ->where('id_kegiatan', $kode_kegiatan)
            ->where('bulan_kegiatan', $bulan_kegiatan)
            ->where('tahun_kegiatan', $tahun_kegiatan)
            ->get();

        // $ids = $data->pluck('id');
        
        // $peta_list = linkPeta::select('id', 'nama_file', 'link_file')
        //         ->where('id_history_folder', $ids)
        //         ->get();
        
        return response()->json([
            'data' => $data,
            // 'list_peta' => $peta_list,
        ]);

        // return response()->json($data);
    }

    public function getPrevBaru(Request $request) 
    {
        $link = $request->input('link');
        preg_match('/folders\/([a-zA-Z0-9_-]+)/', $link, $matches);
        if (!isset($matches[1])) {
            return back()->withErrors(['folder_url' => 'Link folder tidak valid.']);
        }

        $folderId = $matches[1];
        $apiKey = config('services.google.api_key');

        $response = Http::get('https://www.googleapis.com/drive/v3/files', [
            'q' => "'{$folderId}' in parents and trashed = false",
            'fields' => 'files(id,name,webViewLink, mimeType)',
            'key' => $apiKey,
            'pageSize' => 1000,
        ]);

        $files = $response->json()['files'] ?? [];

        $result = [];
        foreach ($files as $file) {
            $id = $file['id'];
            $name = $file['name'];
            $mime = $file['mimeType'];

            $link = ($mime === 'application/vnd.google-apps.folder')
                ? "https://drive.google.com/drive/folders/{$id}"
                : "https://drive.google.com/file/d/{$id}/view?usp=sharing";

            $result[] = [
                'name' => $name,
                'link' => $link,
            ];
        }

        return $result;
    }

    // public function edit(Request $request) {
    //     $history_id = $request->input('history_id');
    //     $link = $request->input('folder_url');
    //     $tabelPeta = $request->input('hasilPrev');

    //     $parseTabel = json_decode($tabelPeta, true);

    //     $deletePetaTerdaftar = linkPeta::where('id_history_folder', $history_id)->delete();

    //     $history = historyFolderPeta::where('id', $history_id)->get();
       
    //     if (isset($parseTabel) && is_array($parseTabel)) {
    //         if ($history->jenis_peta == "WB") {
    //             foreach ($parseTabel as $item) {
    //                 linkPeta::create([
    //                     'kode_jenis' => $history->jenis_peta,
    //                     'kode_kegiatan' => $history->id_kegiatan,
    //                     'nama_file' => $item['name'],
    //                     'link_file' => $item['link'],
    //                     'bs_lengkap' => substr($item['name'], 0, 13), 
    //                     'kode_kec' => substr($item['name'], 4, 3),
    //                     'kode_kel' => substr($item['name'], 7, 3),
    //                     'kode_bs' => substr($item['name'], 10, 4),
    //                     'tahun_kegiatan' => $history->tahun_kegiatan,
    //                     'id_history_folder' => $history->id,
    //                 ]);
    //             }
    //         } else {
    //             foreach ($parseTabel as $item) {
    //                 linkPeta::create([
    //                     'kode_jenis' => $history->jenis_peta,
    //                     'kode_kegiatan' =>  $history->id_kegiatan,
    //                     'nama_file' => $item['name'],
    //                     'link_file' => $item['link'],
    //                     'bs_lengkap' => substr($item['name'], 0, 10), 
    //                     'kode_kec' => substr($item['name'], 4, 3),
    //                     'kode_kel' => substr($item['name'], 7, 3),
    //                     'tahun_kegiatan' => $history->tahun_kegiatan,
    //                     'id_history_folder' => $history->id,
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect('/input-peta')->with('success', 'Edit peta berhasil');
    // }
    public function submit(Request $request) {
        $history_id = $request->input('history_id');
        $link = $request->input('folder_url');
        $tabelPeta = json_decode($request->input('hasilPrev'), true);

        try {
            DB::transaction(function () use ($history_id, $link, $tabelPeta) {
                $history = historyFolderPeta::findOrFail($history_id);
                $history->link_folder = $link;
                $history->save();

                linkPeta::where('id_history_folder', $history_id)->delete();

                foreach ($tabelPeta as $item) {
                    if (empty($item['name']) || empty($item['link'])) {
                        throw new \Exception('Nama file atau link kosong');
                    }

                    linkPeta::create([
                        'kode_jenis'        => $history->jenis_peta,
                        'kode_kegiatan'     => $history->id_kegiatan,
                        'nama_file'         => $item['name'],
                        'link_file'         => $item['link'],
                        'bs_lengkap'        => $history->jenis_peta == "WB"
                                                ? substr($item['name'], 0, 13)
                                                : substr($item['name'], 0, 10),
                        'kode_kec'          => substr($item['name'], 4, 3),
                        'kode_kel'          => substr($item['name'], 7, 3),
                        'kode_bs'           => $history->jenis_peta == "WB"
                                                ? substr($item['name'], 10, 4)
                                                : null,
                        'tahun_kegiatan'    => $history->tahun_kegiatan,
                        'id_history_folder' => $history->id,
                    ]);
                }
            });

            return redirect('/input-peta')->with('success', 'Edit peta berhasil');
        } catch (\Exception $e) {
            return redirect('/input-peta')->with('error', 'Edit peta gagal: ' . $e->getMessage());
        }
    }
}
