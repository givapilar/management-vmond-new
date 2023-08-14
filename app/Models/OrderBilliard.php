<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBilliard extends Model
{
    use HasFactory;

    protected $table = 'order_billiards';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function paketMenu()
    {
        return $this->belongsTo(MenuPackages::class);
    }

    public function orderAddOn()
    {
        return $this->hasMany(OrderAddOn::class);
    }

}
