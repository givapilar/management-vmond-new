<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class DaftarStokController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:departement-list', ['only' => 'index']);
        // $this->middleware('permission:departement-create', ['only' => ['create','store']]);
        // $this->middleware('permission:departement-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:departement-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Daftar Stok';
        $data['materials'] = Material::orderby('id', 'asc')->get();
        // dd($data['materials']->stokMasuk);
        
        return view('inventory.daftar-stok.index', $data);
    }
}
