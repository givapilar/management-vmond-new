<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddOn extends Model
{
    use HasFactory;

    protected $table = 'order_add_ons';

    public function orderPivot()
    {
        return $this->belongsTo(OrderPivot::class);
    }

    public function addOnDetail()
    {
        return $this->belongsTo(AddOnDetail::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }

}
