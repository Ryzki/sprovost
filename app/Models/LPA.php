<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LPA extends Model
{
    use HasFactory;
    protected $table = 'lpas';

    protected $fillable = [
        'data_pelanggar_id',
        'no_lpa',
        'created_by'
    ];

    function user(){
        return $this->hasMany(User::class, 'id', 'created_by');
    }
}
