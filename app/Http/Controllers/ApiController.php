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
        try {
            if ($type == 'resto') $getData = Restaurant::where('slug', $slug)->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['image'] = asset('assets/images/restaurant/'.$item->image);
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                return $data;
            });

            if ($type == 'billiard') $getData = Biliard::where('slug', $slug)->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['image'] = asset('assets/images/biliard/'.$item->image);
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                return $data;
            });

            if ($type == 'meetingroom') $getData = MeetingRoom::where('slug', $slug)->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['image'] = asset('assets/images/meeting-room/'.$item->image);
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                return $data;
            });

            $json = [
                "success" => true,
                "message"=> "Berhasil get data!",
                "code"=> 200,
                "data" => $getData
            ];
            return $json;
        } catch (\Throwable $th) {
            $json = [
                "success" => false,
                "message"=> "Failed get data!, ". $th->getMessage(),
                "code"=> 500,
                "data" => []
            ];
            return $json;
        }
    }
}
