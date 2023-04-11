<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelarPerkara extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_pelanggar_id',
        'tgl_pelaksanaan',
        'waktu_pelaksanaan',
        'tempat_pelaksanaan',
        'pimpinan',
        'operator',
        'notulen',
        'pemapar',
        'hasil_gelar',
        'landasan_hukum',
        'keterangan_hasil'
    ];

    public function penyidik()
    {
        return $this->hasOne(Penyidik::class, 'id', 'pimpinan');
    }

    public function operator()
    {
        return $this->hasOne(Penyidik::class, 'id', 'operator');
    }

    public function notulen()
    {
        return $this->hasOne(Penyidik::class, 'id', 'notulen');
    }

    public function pemapar()
    {
        return $this->hasOne(Penyidik::class, 'id', 'pemapar');
    }
}
