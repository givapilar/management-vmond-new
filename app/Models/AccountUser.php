<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountUser extends Model
{
    use HasFactory;

    protected $table = 'account_users';

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function order()
    {
        return $this->belongsTo (Order::class);
    }

}
