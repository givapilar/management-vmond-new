<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
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
        $data['page_title'] = 'Bahan Baku';
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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Bahan Baku '.$request->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('bahan-baku.index')->with(['success' => 'Bahan Baku added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('bahan-baku.index')->with(['failed' => 'Bahan Baku added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Bahan Baku';
        $data['materials'] = Material::find($id);

        return view('master-data.material.edit',$data);
    }

    public function show(){
        
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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Bahan Baku '.$request->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('bahan-baku.index')->with(['success' => 'Bahan Baku edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('bahan-baku.index')->with(['failed' => 'Bahan Baku edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $role = Material::findOrFail($id);
            $role->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Bahan Baku '.$role->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Bahan Baku deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
