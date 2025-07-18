<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';
    protected $primaryKey = 'jenis_peta';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
