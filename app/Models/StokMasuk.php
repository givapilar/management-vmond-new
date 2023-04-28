<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $table = 'stok_masuk';
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
