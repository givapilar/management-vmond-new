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

    public function orderMeeting()
    {
        return $this->hasMany(OrderMeeting::class);
    }

    public function orderMeetingMakananTime($time)
    {
        return OrderMeeting::where('order_id', $this->id)->where('category', 'Makanan')->where('time_from', '<', $time)->get();
    }

    public function orderBilliardMakananTime($time)
    {
        return OrderBilliard::where('order_id', $this->id)->where('category', 'Makanan')->where('time_from', '<', $time)->get();
    }
}
