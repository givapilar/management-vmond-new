<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use App\Models\MeetingRoom;
use App\Models\Restaurant;
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

    public function getApiDetail($type, $slug){
        if ($type == 'resto') {
            $getData = Restaurant::where('slug', $slug)->limit(1)->get();
            return $getData;
        }
    }
}
