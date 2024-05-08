<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_organization_type',
        'org_alamat',
        'org_defined_id',
        'org_kode',
        'org_kota',
        'org_logo',
        'org_nama',
        'org_nama_singkat',
        'org_telp',
        'org_website',
        'id_user',
        'org_email',
        'parent_organization_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($organization) {
            // Set nilai default 'not set' jika tidak ada nilai yang diberikan
            if (empty($organization->org_email)) {
                $organization->org_email = 'not set';
            }
            if (empty($organization->org_website)) {
                $organization->org_website = 'not set';
            }
            if (empty($organization->org_telp)) {
                $organization->org_telp = 'not set';
            }
        });
    }
}
