<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueInputPeta implements ValidationRule
{
    protected $tahunKegiatan;

    public function __construct($tahunKegiatan)
    {
        $this->tahunKegiatan = $tahunKegiatan;
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
            ->where('tahun_kegiatan', $this->tahunKegiatan)
            ->exists();

        if ($exists) {
            $fail('Kegiatan dan tahun ini sudah pernah terdaftar di history folder.');
        }
    }
}
