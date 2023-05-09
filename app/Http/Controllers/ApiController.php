<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Biliard;
use App\Models\MeetingRoom;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class ApiController extends Controller
{
    public function getApiBiliard()
    {
        $meeting_room = Biliard::get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/biliard/' . $item->image);
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($meeting_room);
    }

    public function getApiMeetingRoom()
    {
        $meeting_room = MeetingRoom::get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/meeting-room/' . $item->image);
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($meeting_room);
    }

    public function getApiDetailRestaurant($type, $slug){
        if ($type == 'resto') {
            $getData = Restaurant::where('slug', $slug)->limit(1)->get();
            return $getData;
        }
    }

    public function getApiBanner()
    {
        // $image = Storage::get($path);
        $banner = Banner::get()->map(function($item){
            $data['id'] = $item->id;
            $data['image'] = asset('assets/images/banner/' . $item->image);
            return $data;
        });

        return response()->json($banner);
    
    }
    public function getApiResto()
    {
        // $image = Storage::get($path);
        $banner = Restaurant::get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/restaurant/' . $item->image);
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($banner);
    }
   
}
