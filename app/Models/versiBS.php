<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class versiBS extends Model
{
    use HasFactory;

    protected $table = 'versi_bs';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
