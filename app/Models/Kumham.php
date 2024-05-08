<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kumham extends Model
{
    use HasFactory;

    protected $fillable = [
        'kumham_nomor_sk',
        'kumham_tgl_sk',
        'kumham_dokumen',
        'id_akta',
        'id_user'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($organization) {
           
            if (empty($organization->kumham_nomor_sk)) {
                $organization->kumham_nomor_sk = 'not set';
            }
            if (empty($organization->kumham_tgl_sk)) {
                $organization->kumham_tgl_sk = '1000-01-01';
            }
        });
    }

}
