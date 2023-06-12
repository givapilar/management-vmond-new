<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPackages extends Model
{
    use HasFactory;

    public function biliard()
    {
        return $this->belongsTo(Biliard::class, 'billiard_id', 'id');
    }

    public function roomMeet()
    {
        return $this->belongsTo(MeetingRoom::class, 'room_meeting_id', 'id');
    }

    public function MenuPackagePivots()
    {
        return $this->hasMany(MenuPackagePivots::class);
    }
}
