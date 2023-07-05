<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MejaControl extends Model
{
    use HasFactory;

    public function Billiard()
    {
        return $this->belongsTo(Biliard::class, 'billiard_id', 'id');
    }
}
