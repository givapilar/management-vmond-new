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
        $meeting_room = Biliard::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/biliard/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($meeting_room);
    }

    public function getApiMeetingRoom()
    {
        $meeting_room = MeetingRoom::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/meeting-room/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($meeting_room);
    }

    public function getApiDetail($type, $slug){
        try {
            if ($type == 'resto') $getData = Restaurant::where('slug', $slug)->orderBy('id', 'ASC')->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['image'] = asset('assets/images/restaurant/'.($item->image ?? 'no-pictures.png'));
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                $data['type'] = strtoupper('MENU '. $item->category);
                return $data;
            });

            if ($type == 'billiard') $getData = Biliard::where('slug', $slug)->orderBy('id', 'ASC')->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['image'] = asset('assets/images/biliard/'.($item->image ?? 'no-pictures.png'));
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                $data['type'] = 'MEJA BILLIARD';
                return $data;
            });

            if ($type == 'meetingroom') $getData = MeetingRoom::where('slug', $slug)->orderBy('id', 'ASC')->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['image'] = asset('assets/images/meeting-room/'.($item->image ?? 'no-pictures.png'));
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                $data['type'] = 'MEETING ROOM';
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

    public function getApiBanner()
    {
        // $image = Storage::get($path);
        $banner = Banner::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['image'] = asset('assets/images/banner/' . ($item->image ?? 'no-pictures.png'));
            return $data;
        });

        return response()->json($banner);

    }
    public function getApiResto()
    {
        // $image = Storage::get($path);
        $banner = Restaurant::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/restaurant/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($banner);
    }

}
