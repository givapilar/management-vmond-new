<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StokMasuk;

class Material extends Model
{
    use HasFactory;

    protected $table = 'material';

    public function stokMasuk()
    {
        return $this->hasMany(StokMasuk::class, 'material_id', 'id');
    }
    
    public function stokKeluar()
    {
        return $this->hasMany(StokKeluar::class, 'material_id', 'id');
    }

}
