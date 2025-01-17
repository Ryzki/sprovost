<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelanggar extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_nota_dinas', 'no_pengaduan', 'pelapor', 'umur', 'jenis_kelamin', 'pekerjaan', 'agama',
        'alamat', 'no_identitas', 'jenis_identitas', 'terlapor', 'kesatuan', 'tempat_kejadian','nrp','tanggal_kejadian', 'kronologi',
        'pangkat','jabatan', 'nama_korban', 'status_id', 'no_telp', 'kewarganegaraan', 'perihal_nota_dinas', 'tanggal_nota_dinas',
        'wujud_perbuatan', 'wilayah_hukum', 'created_at', 'kategori_yanduan_id', 'data_from'
    ];

    public function status()
    {
        return $this->hasOne(Process::class, 'id', 'status_id');
    }

    public function religi()
    {
        return $this->hasOne(Agama::class, 'id', 'agama');
    }

    public function identitas()
    {
        return $this->hasOne(JenisIdentitas::class, 'id', 'jenis_identitas');
    }

    public function pangkatName()
    {
        return $this->hasOne(Pangkat::class, 'id', 'pangkat');
    }

    public function wujudPerbuatan()
    {
        return $this->hasOne(WujudPerbuatan::class, 'id', 'wujud_perbuatan');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'data_pelanggar_id', 'id');
    }

    public function sidangDisiplin(){
        return $this->hasOne(SidangDisiplin::class, 'data_pelanggar_id', 'id');
    }

    public function kategoriYanduan(){
        return $this->hasOne(KategoriYanduan::class,'id', 'kategori_yanduan_id');
    }

    public function evidenceReference(){
        return $this->hasMany(EvidenceReferenceModel::class, 'data_pelanggar_id', 'id');
    }

    public function witnessReference(){
        return $this->hasOne(WitnessReferenceModel::class, 'data_pelanggar_id', 'id');
    }

    public function identityReference(){
        return $this->hasOne(PelaporIdentityReference::class, 'data_pelanggar_id', 'id');
    }
}
