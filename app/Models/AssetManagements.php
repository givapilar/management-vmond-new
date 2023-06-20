<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetManagements extends Model
{
    use HasFactory;

    public function detailAsset()
    {
        return $this->hasMany(AssetManagementDetail::class ,'asset_management_id', 'id');
    }
}
