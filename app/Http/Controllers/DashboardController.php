<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use DateTime;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';
        $data['materials'] = Material::orderby('id', 'asc')->get();
        $data['stock_masuk'] = StokMasuk::get()->sum('material_masuk');
        $data['stock_keluar'] = StokKeluar::get()->sum('material_keluar');
        
        
        $data['start_date'] = date('Y-m-01', strtotime($request->start_date));
        if ($request->start_date) {
            $start_date = new DateTime(Carbon::parse($request->start_date)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($request->start_date)->endOfMonth()->format('Y/m/d'));
        } else {
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }
        
        
        
        $data['date'] = [];
        $data['stok_masuk'] = [];
        $data['stok_keluar'] = [];

        

        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
            array_push($data['date'], $day->format('d'));
             $stok_masuk = StokMasuk::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->get();
             $stok_keluar = StokKeluar::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->get();
             $masuk = $stok_masuk->sum('material_masuk'); 
             $keluar = $stok_keluar->sum('masterial_keluar');

            array_push($data['stok_masuk'], $masuk);
            array_push($data['stok_keluar'], $keluar);
        }
        return view('dashboard.index', $data);
    }
}
