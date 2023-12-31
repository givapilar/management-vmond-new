<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';

    public function restaurantTag()
    {
        return $this->hasMany(RestaurantPivots::class);
    }

    public function restaurantAddOn()
    {
        return $this->hasMany(RestaurantAddOn::class);
    }

    public function restaurantPackage()
    {
        return $this->hasMany(MenuPackagePivots::class);
    }

    public function orderPivot()
    {
        return $this->hasMany(OrderPivots::class);
    }
}
