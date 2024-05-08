<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcaraPerkaraStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bap_status', 'bap_keterangan', 'id_bap', 'id_user'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($berita_acara_perkara_status) {
            // Set nilai default 'not set' jika tidak ada nilai yang diberikan
            if (empty($berita_acara_perkara_status->bap_keterangan)) {
                $berita_acara_perkara_status->bap_keterangan = 'not set';
            }
           
        });
    }

}
