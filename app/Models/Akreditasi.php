<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'akreditasi_sk',
        'akreditasi_defined_id',
        'akreditasi_tgl_dibuat',
        'akreditasi_tgl_awal',
        'akreditasi_tgl_akhir',
        'akreditasi_status',
        'id_peringkat_akreditasi',
        'id_organization',
        'id_lembaga_akreditasi',
        'id_user',
        'id_prodi',
        'akreditasi_dokumen'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($akreditasi) {
            // Set nilai default 'not set' jika tidak ada nilai yang diberikan
            if (empty($akreditasi->akreditasi_sk)) {
                $akreditasi->akreditasi_sk = 'not set';
            }
            if (empty($akreditasi->akreditasi_tgl_dibuat)) {
                $akreditasi->akreditasi_tgl_dibuat	 = '1000-01-01';
            }
            if (empty($akreditasi->akreditasi_tgl_awal)) {
                $akreditasi->akreditasi_tgl_awal	 = '1000-01-01';
            }
            if (empty($akreditasi->akreditasi_tgl_akhir)) {
                $akreditasi->akreditasi_tgl_akhir	 = '1000-01-01';
            }
            if (empty($akreditasi->akreditasi_status)) {
                $akreditasi->akreditasi_status = 'not set';
            }
            if (empty($akreditasi->akreditasi_dokumen)) {
                $akreditasi->akreditasi_dokumen = 'not_set.png';
            }
           
        });
    }


}
