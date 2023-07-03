<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function orderPivot()
    {
        return $this->hasMany(OrderPivot::class);
    }

    public function orderBilliard()
    {
        return $this->hasMany(OrderBilliard::class);
    }
}
