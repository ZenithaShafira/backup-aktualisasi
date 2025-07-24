<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyFolderPeta extends Model
{
    use HasFactory;

    protected $table = 'history_folder_peta';
    protected $fillable = ['id_kegiatan', 'bulan_kegiatan', 'tahun_kegiatan', 'jenis_peta', 'versi_bs', 'link_folder', 'created_at', 'updated_at'];
    
    public function kegiatan()
    {
        return $this->belongsTo(kegiatan::class, 'id_kegiatan', 'kode_kegiatan');
    }    
}

