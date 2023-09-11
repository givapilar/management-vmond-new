<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MejaRestaurants extends Model
{
    use HasFactory;

    public function deleteWithOrders()
    {
        $this->orders()->update(['meja_restaurant_id' => null]);
        $this->delete();
    }

    // Relasi dengan tabel Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'meja_restaurant_id');
    }
}
