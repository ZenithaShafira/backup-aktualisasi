<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueInputPeta implements ValidationRule
{
    protected $tahunKegiatan;
    protected $bulanKegiatan;

    public function __construct($tahunKegiatan, $bulanKegiatan)
    {
        $this->tahunKegiatan = $tahunKegiatan;
        $this->bulanKegiatan = $bulanKegiatan;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('history_folder_peta')
            ->where('id_kegiatan', $value)
            ->where('bulan_kegiatan', $this->bulanKegiatan)
            ->where('tahun_kegiatan', $this->tahunKegiatan)
            ->exists();

        if ($exists) {
            $fail('Kegiatan, bulan, dan tahun ini sudah pernah terdaftar di history folder.');
        }
    }
}