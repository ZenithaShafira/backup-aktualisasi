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
                            'kode_kegiatan',
                            'id_history_folder'
                        ];

    public $timestamps = false;
}
