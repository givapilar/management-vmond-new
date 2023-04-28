<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokMasuk;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StokMasukController extends Controller
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
        $data['page_title'] = 'Stok Masuk';
        $data['stok_masuks'] = StokMasuk::orderby('id', 'asc')->get();
        $data['materials'] = Material::get();
        
        return view('inventory.stok-masuk.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Stok Masuk';
        $data['stok-masuk'] = StokMasuk::get();
        $data['materials'] = Material::get();

        return view('inventory.stok-masuk.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_masuk' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = new StokMasuk();
            $material->material_id = $validateData['material_id'];
            $material->material_masuk = $validateData['material_masuk'];
            $material->description = $validateData['description'];
            
            $material->save();

            return redirect()->route('stok-masuk.index')->with(['success' => 'Stok Masuk added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('stok-masuk.index')->with(['failed' => 'Stok Masuk added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Material';
        $data['materials'] = Material::find($id);

        return view('master-data.material.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_masuk' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = StokMasuk::findOrFail($id);
            $material->material_id = $validateData['material_id'];
            $material->material_masuk = $validateData['material_masuk'];
            $material->description = $validateData['description'];
            

            $material->save();

            return redirect()->route('stok-masuk.index')->with(['success' => 'Stok Masuk Berhasil Diedit!']);
        } catch (\Throwable $th) {
            return redirect()->route('stok-masuk.index')->with(['failed' => 'Stok Masuk Gagal edited! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stok_masuk = StokMasuk::findOrFail($id);
            $stok_masuk->delete();
        });
        
        Session::flash('success', 'Stok Masuk deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
