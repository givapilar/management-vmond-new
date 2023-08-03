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

    public function user()
    {
        return $this->belongsTo(AccountUser::class, 'user_id');
    }

    public function paketMenu()
    {
        return $this->belongsTo(MenuPackages::class);
    }

    public function tableRestaurant()
    {
        return $this->belongsTo(MejaRestaurants::class, 'meja_restaurant_id');
    }
    public function tableBilliard()
    {
        return $this->belongsTo(Biliard::class, 'biliard_id');
    }
    public function tableMeetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class, 'meeting_room_id');
    }

    public function orderBilliard()
    {
        return $this->hasMany(OrderBilliard::class);
    }

    public function orderMeeting()
    {
        return $this->hasMany(OrderMeeting::class);
    }

    // Makanan
    public function orderMeetingMakananTime($time)
    {
        return OrderMeeting::where('order_id', $this->id)->where('category', 'Makanan')->where('time_from', '<', $time)->get();
    }

    public function orderBilliardMakananTime($time)
    {
        return OrderBilliard::where('order_id', $this->id)->where('category', 'Makanan')->where('time_from', '<', $time)->get();
    }

    public function orderPivotMakanan()
    {
        return OrderPivot::where('order_id', $this->id)->where('category', 'Makanan')->get();
    }
    
    public function orderMeetingMakananTimeDone($time)
    {
        return OrderMeeting::where('order_id', $this->id)->where('category', 'Makanan')->where('status_pemesanan', 'Selesai')->where('time_from', '<', $time)->get();
    }

    public function orderBilliardMakananTimeDone($time)
    {
        return OrderBilliard::where('order_id', $this->id)->where('category', 'Makanan')->where('status_pemesanan', 'Selesai')->where('time_from', '<', $time)->get();
    }

    public function orderPivotMakananDone()
    {
        return OrderPivot::where('order_id', $this->id)->where('category', 'Makanan')->where('status_pemesanan', 'Selesai')->get();
    }

    // Minuman
    public function orderMeetingMinumanTime($time)
    {
        return OrderMeeting::where('order_id', $this->id)->where('category', 'Minuman')->where('time_from', '<', $time)->get();
    }

    public function orderBilliardMinumanTime($time)
    {
        return OrderBilliard::where('order_id', $this->id)->where('category', 'Minuman')->where('time_from', '<', $time)->get();
    }

    public function orderPivotMinuman()
    {
        return OrderPivot::where('order_id', $this->id)->where('category', 'Minuman')->get();
    }
   
    public function orderMeetingMinumanTimeDone($time)
    {
        return OrderMeeting::where('order_id', $this->id)->where('category', 'Minuman')->where('status_pemesanan', 'Selesai')->where('time_from', '<', $time)->get();
    }

    public function orderBilliardMinumanTimeDone($time)
    {
        return OrderBilliard::where('order_id', $this->id)->where('category', 'Minuman')->where('status_pemesanan', 'Selesai')->where('time_from', '<', $time)->get();
    }

    public function orderPivotMinumanDone()
    {
        return OrderPivot::where('order_id', $this->id)->where('category', 'Minuman')->where('status_pemesanan', 'Selesai')->get();
    }
}
