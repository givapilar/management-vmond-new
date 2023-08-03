<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnBilliard extends Model
{
    use HasFactory;

    public function detailAddOnBilliard()
    {
        return $this->hasMany(AddOnDetailBilliard::class);
    }
}
