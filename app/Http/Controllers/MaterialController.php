<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class MaterialController extends Controller
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
        $data['page_title'] = 'Material';
        $data['materials'] = Material::orderby('id', 'asc')->get();
        
        return view('master-data.material.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Material';
        $data['materials'] = Material::get();

        return view('master-data.material.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'code' => 'required',
            'nama' => 'required',
            'unit' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = new Material();
            $material->code = $validateData['code'];
            $material->nama = $validateData['nama'];
            $material->unit = $validateData['unit'];
            $material->description = $validateData['description'];
            
            $material->save();

            return redirect()->route('material.index')->with(['success' => 'Material added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('material.index')->with(['failed' => 'Material added failed! '.$th->getMessage()]);
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
            'code' => 'required',
            'nama' => 'required',
            'unit' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = Material::findOrFail($id);
            $material->code = $validateData['code'];
            $material->nama = $validateData['nama'];
            $material->unit = $validateData['unit'];
            $material->description = $validateData['description'];
            

            $material->save();

            return redirect()->route('material.index')->with(['success' => 'Material edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('material.index')->with(['failed' => 'Material edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $role = Material::findOrFail($id);
            $role->delete();
        });
        
        Session::flash('success', 'Material deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
