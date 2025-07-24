<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\kegiatan;
use App\Models\jenis;
use App\Models\versiBS;
use App\Models\historyFolderPeta;
use App\Models\linkPeta;
use App\Rules\UniqueInputPeta;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class InputPetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kegiatan = kegiatan::all(); 
        $jenis = jenis::all();
        $versi = versiBS::all();

        return view('input-peta', compact('kegiatan', 'jenis', 'versi'));
    }

    public function showPreview(Request $request) {
        $request->validate([
            'kegiatan_id' => [
                'required',
                Rule::exists('kegiatan', 'kode_kegiatan'),
                new UniqueInputPeta($request->tahun_kegiatan),
            ],
            'tahun_kegiatan' => 'required',
            'jenis_peta' => [
                'required',
                Rule::exists('jenis', 'jenis_peta')
            ],
            'versi' => [
                "nullable",
                Rule::exists('versi_bs', 'id')
            ],
            'folder_url' => 'required|url',
            'bulan_kegiatan' => 'required'
        ], [
            'kegiatan_id.required' => 'Kegiatan belum terisi',
            'kegiatan_id.exists' => 'Kegiatan tidak valid',
            'tahun_kegiatan.required' => 'Tahun belum terisi',
            'jenis_peta.required' => 'Jenis peta belum terisi',
            'jenis_peta.exists' => 'Jenis peta tidak valid',
            'folder_url.required' => 'Link folder belum terisi',
            'versi.exists' => 'Versi tidak valid',
            'folder_url.required' => 'Link folder belum terisi',
            'folder_url.url' => 'Format link folder tidak sesuai',
            'bulan_kegiatan.required' => 'Bulan belum terisi',
        ]);

        // Ambil folder ID dari URL
        preg_match('/folders\/([a-zA-Z0-9_-]+)/', $request->folder_url, $matches);
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

        return [
            'files'             => $result,
            'kegiatan_id'       => $request->kegiatan_id,
            'tahun_kegiatan'    => $request->tahun_kegiatan,
            'bulan_kegiatan'    => $request->bulan_kegiatan,
            'jenis_peta'        => $request->jenis_peta,
            'versi'             => $request->versi,
            'link'              => $request->folder_url,
        ];
    }

    // public function store(Request $request) {
    //     $request->validate([
    //         'store_peta'           => 'required|json',
    //         'store_kegiatan_id'    => 'required',
    //         'store_tahun'          => 'required',
    //         'store_bulan'          => 'required',
    //         'store_jenis'          => 'required',
    //         'store_versi'          => 'nullable',
    //         'store_link'           => 'required',
    //     ]);

    //     $kode_kegiatan = $request->input('store_kegiatan_id');
    //     $tahun = $request->input('store_tahun');
    //     $bulan = $request->input('store_bulan');
    //     $jenis = $request->input('store_jenis');
    //     $versi = $request->input('store_versi');
    //     $link = $request->input('store_link');
    //     $tabelPeta = $request->input('store_peta');

    //     $parseTabel = json_decode($tabelPeta, true);

    //     $history = historyFolderPeta::create([
    //         'id_kegiatan' => $kode_kegiatan,
    //         'bulan_kegiatan' => $bulan,
    //         'tahun_kegiatan' => $tahun, 
    //         'jenis_peta' => $jenis,
    //         'versi_bs' => $versi,
    //         'link_folder' => $link
    //     ]);

    //     if (isset($parseTabel) && is_array($parseTabel)) {
    //         if ($jenis == "WB") {
    //             foreach ($parseTabel as $item) {
    //                 linkPeta::create([
    //                     'kode_jenis' => $jenis,
    //                     'kode_kegiatan' => $kode_kegiatan,
    //                     'nama_file' => $item['name'],
    //                     'link_file' => $item['link'],
    //                     'bs_lengkap' => substr($item['name'], 0, 13), 
    //                     'kode_kec' => substr($item['name'], 4, 3),
    //                     'kode_kel' => substr($item['name'], 7, 3),
    //                     'kode_bs' => substr($item['name'], 10, 4),
    //                     'tahun_kegiatan' => $tahun,
    //                     'id_history_folder' => $history->id,
    //                 ]);
    //             }
    //         } else {
    //             foreach ($parseTabel as $item) {
    //                 linkPeta::create([
    //                     'kode_jenis' => $jenis,
    //                     'kode_kegiatan' => $kode_kegiatan,
    //                     'nama_file' => $item['name'],
    //                     'link_file' => $item['link'],
    //                     'bs_lengkap' => substr($item['name'], 0, 10), 
    //                     'kode_kec' => substr($item['name'], 4, 3),
    //                     'kode_kel' => substr($item['name'], 7, 3),
    //                     'tahun_kegiatan' => $tahun,
    //                     'id_history_folder' => $history->id,
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect('/input-peta')->with('success', 'Simpan peta berhasil');

    //     // return [
    //     //     'files'       => $request->store_peta,
    //     //     'kegiatan_id' => $request->store_kegiatan_id,
    //     //     'tahun'       => $request->store_tahun,
    //     //     'jenis_peta'  => $request->store_jenis,
    //     //     'versi'       => $request->store_versi,
    //     //     'tes id' => $history->id
    //     // ];
    // }

    public function store(Request $request)
{
    $request->validate([
        'store_peta'           => 'required|json',
        'store_kegiatan_id'    => 'required',
        'store_tahun'          => 'required',
        'store_bulan'          => 'required',
        'store_jenis'          => 'required',
        'store_versi'          => 'nullable',
        'store_link'           => 'required',
    ]);

    $kode_kegiatan = $request->input('store_kegiatan_id');
    $tahun  = $request->input('store_tahun');
    $bulan  = $request->input('store_bulan');
    $jenis  = $request->input('store_jenis');
    $versi  = $request->input('store_versi');
    $link   = $request->input('store_link');
    $tabelPeta = json_decode($request->input('store_peta'), true);

    try {
        DB::transaction(function () use ($kode_kegiatan, $tahun, $bulan, $jenis, $versi, $link, $tabelPeta) {

            $history = historyFolderPeta::create([
                'id_kegiatan'    => $kode_kegiatan,
                'bulan_kegiatan' => $bulan,
                'tahun_kegiatan' => $tahun, 
                'jenis_peta'     => $jenis,
                'versi_bs'       => $versi,
                'link_folder'    => $link
            ]);

            foreach ($tabelPeta as $item) {
                // misal validasi manual
                if (empty($item['name']) || empty($item['link'])) {
                    throw new \Exception('Nama file atau link kosong');
                }

                linkPeta::create([
                    'kode_jenis'        => $jenis,
                    'kode_kegiatan'     => $kode_kegiatan,
                    'nama_file'         => $item['name'],
                    'link_file'         => $item['link'],
                    'bs_lengkap'        => ($jenis == "WB") ? substr($item['name'], 0, 13) : substr($item['name'], 0, 10),
                    'kode_kec'          => substr($item['name'], 4, 3),
                    'kode_kel'          => substr($item['name'], 7, 3),
                    'kode_bs'           => ($jenis == "WB") ? substr($item['name'], 10, 4) : null,
                    'tahun_kegiatan'    => $tahun,
                    'id_history_folder' => $history->id,
                ]);
            }
        });

        return redirect('/edit-peta')->with('success', 'Simpan peta berhasil');

    } catch (\Exception $e) {
        return redirect('/edit-peta')->with('error', 'Gagal simpan peta: ' . $e->getMessage());
    }
}
}
