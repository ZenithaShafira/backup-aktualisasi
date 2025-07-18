<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $primaryKey = 'kode_kegiatan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nama_kegiatan', 'kode_kegiatan'];

    public $timestamps = false;
}
