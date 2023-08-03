<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnDetailBilliard extends Model
{
    use HasFactory;

    public function addOnBilliard()
    {
        return $this->belongsTo(AddOnBilliard::class);
    }
}
