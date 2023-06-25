<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnDetail extends Model
{
    use HasFactory;

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
