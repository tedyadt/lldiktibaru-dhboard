<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcaraPerkara extends Model
{
    use HasFactory;

    protected $fillable = [
        'bap_perkara', 'bap_defined_id', 'id_organization', 'id_user'
    ];

}
