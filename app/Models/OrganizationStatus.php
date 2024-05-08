<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_organization', 'org_status', 'id_akta'
    ];
}
