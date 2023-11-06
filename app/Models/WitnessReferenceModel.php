<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WitnessReferenceModel extends Model
{
    use HasFactory;
    protected $table = 'witness_reference';
    protected $guarded = [];
}
