<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetManagementDetail extends Model
{
    use HasFactory;

    public function Asset()
    {
        return $this->belongsTo(AssetManagement::class);
    }
}
