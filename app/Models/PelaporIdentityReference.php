<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporIdentityReference extends Model
{
    use HasFactory;
    protected $table = 'pelapor_identity_reference';
    protected $guarded = [];
}
