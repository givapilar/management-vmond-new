<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
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

    public function index(Request $request)
    {
        $data['page_title'] = 'Stok Keluar';
        // $data['stok_keluars'] = StokKeluar::orderby('id', 'asc')->get();
        $data['materials'] = Material::get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = StokKeluar::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = StokKeluar::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = StokKeluar::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = StokKeluar::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }
   
        $data['stok_keluars'] = $stok;

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Stok Keluar '.$material->material->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Stok Keluar '.$material->material->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Stok Keluar '.$stok_keluar->material->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('failed', 'Stok Keluar deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
