<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\StokKeluar;
use App\Models\StokMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Dashboard';
        $data['materials'] = Material::orderby('id', 'asc')->get();
        $data['stock_masuk'] = StokMasuk::get()->sum('material_masuk');
        $data['stock_keluar'] = StokKeluar::get()->sum('material_keluar');
        // dd($data['materials']->stokMasuk);
        
        return view('dashboard.index', $data);
    }
}
