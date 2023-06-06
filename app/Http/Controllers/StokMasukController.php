<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Illuminate\Http\Request;
use App\Models\StokMasuk;
use App\Models\Material;
use Carbon\Carbon;
use DateTime;
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

    public function index(Request $request)
    {
        $data['page_title'] = 'Stok Masuk';
        $data['materials'] = Material::orderby('id', 'asc')->get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = StokMasuk::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = StokMasuk::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = StokMasuk::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = StokMasuk::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }
   
        $data['stock_masuks'] = $stok;

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Stok Masuk '.$material->material->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Stok Masuk '.$material->material->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Stok Masuk '.$stok_masuk->material->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Stok Masuk deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
