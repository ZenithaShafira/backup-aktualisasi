<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class linkPeta extends Model
{
    use HasFactory;
    
    protected $table = 'link_peta';
    protected $fillable = ['kode_jenis',
                            'nama_file',
                            'link_file',
                            'kode_kec',
                            'kode_kel',
                            'kode_bs',
                            'kode_sls',
                            'kode_kegiatan',
                            'tahun_kegiatan',
                            'id_history_folder'
                        ];

    public $timestamps = false;

    public function history_folder_peta()
    {
        return $this->belongsTo(historyFolderPeta::class, 'id_history_folder', 'id');
    }
}
