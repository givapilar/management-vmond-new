<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use App\Models\MeetingRoom;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getApiBiliard()
    {
        $data = Biliard::get();

        return $data;
    }

    public function getApiMeetingRoom()
    {
        $data = MeetingRoom::get();

        return $data;
    }
}
