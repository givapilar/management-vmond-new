<?php

namespace App\Http\Controllers;

use App\Models\AssetManagements;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssetManagementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Asset Management List';
        $data['asset_managements'] = AssetManagements::orderby('id', 'asc')->get();
        
        return view('master-data.asset-management.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Asset';
        $data['asset_management'] = AssetManagements::get();

        return view('master-data.asset-management.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'quantity' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $asset_management = new AssetManagements();
            $asset_management->nama = $validateData['nama'];
            $asset_management->quantity = $validateData['quantity'];
            $asset_management->description = $validateData['description'];
            
            $asset_management->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Asset '.$request->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('asset-management.index')->with(['success' => 'Asset Management added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('asset-management.index')->with(['failed' => 'Asset Management added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Asset';
        $data['asset_managements'] = AssetManagements::find($id);

        return view('master-data.asset-management.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'quantity' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $asset_management = AssetManagements::findOrFail($id);
            $asset_management->nama = $validateData['nama'];
            $asset_management->quantity = $validateData['quantity'];
            $asset_management->description = $validateData['description'];
            

            $asset_management->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Asset '.$request->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('asset-management.index')->with(['success' => 'Asset Management edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('asset-management.index')->with(['failed' => 'Asset Management edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $asset_management = AssetManagements::findOrFail($id);
            $asset_management->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Asset '.$asset_management->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Asset Management deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
