<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPackagePivots extends Model
{
    use HasFactory;

    protected $fillable = ['menu_packages_id', 'restaurant_id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
