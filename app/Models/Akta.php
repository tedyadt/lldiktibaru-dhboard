<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akta extends Model
{
    use HasFactory;

    protected $fillable = [
        'akta_nomor',
        'akta_tgl_dibuat',
        'akta_tgl_awal',
        'akta_tgl_akhir',
        'akta_nama_atau_pengesah',
        'akta_kota_notaris',
        'akta_perihal', 
        'akta_jenis', 
        'akta_dokumen',
        'id_user',
        'akta_defined_id',
        'id_organization',
        'id_prodi'
    ];
}
