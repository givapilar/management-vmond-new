<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\StokKeluar;

class DaftarStokController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:departement-list', ['only' => 'index']);
        // $this->middleware('permission:departement-create', ['only' => ['create','store']]);
        // $this->middleware('permission:departement-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:departement-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Daftar Stok';
        // $data['materials'] = Material::orderby('id', 'asc')->get();
        // dd($data['materials']->stokMasuk);

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = Material::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = Material::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = Material::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = Material::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }
   
        $data['materials'] = $stok;
        
        return view('inventory.daftar-stok.index', $data);
    }
}
