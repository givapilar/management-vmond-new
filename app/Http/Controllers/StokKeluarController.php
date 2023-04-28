<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokKeluar;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StokKeluarController extends Controller
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
        $data['page_title'] = 'Stok Keluar';
        $data['stok_keluars'] = StokKeluar::orderby('id', 'asc')->get();
        $data['materials'] = Material::get();
        
        return view('inventory.stok-keluar.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Stok Keluar';
        $data['stok-masuk'] = StokKeluar::get();
        $data['materials'] = Material::get();

        return view('inventory.stok-keluar.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_keluar' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = new StokKeluar();
            $material->material_id = $validateData['material_id'];
            $material->material_keluar = $validateData['material_keluar'];
            $material->description = $validateData['description'];
            
            $material->save();

            return redirect()->route('stok-keluar.index')->with(['success' => 'Stok Keluar added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('stok-keluar.index')->with(['failed' => 'Stok Keluar added failed! '.$th->getMessage()]);
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
            'material_keluar' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = StokKeluar::findOrFail($id);
            $material->material_id = $validateData['material_id'];
            $material->material_keluar = $validateData['material_keluar'];
            $material->description = $validateData['description'];
            

            $material->save();

            return redirect()->route('stok-keluar.index')->with(['success' => 'Stok Material edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('stok-keluar.index')->with(['failed' => 'Stok Material edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stok_keluar = StokKeluar::findOrFail($id);
            $stok_keluar->delete();
        });
        
        Session::flash('failed', 'Stok Keluar deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
