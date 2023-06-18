<?php

namespace App\Http\Controllers;

use App\Models\AssetManagementDetail;
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

    function __construct()
    {
        $this->middleware('permission:asset-management-list', ['only' => 'list']);
        $this->middleware('permission:asset-management-create', ['only' => ['create','store']]);
        $this->middleware('permission:asset-management-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:asset-management-delete', ['only' => ['destroy']]);
    }
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
            // 'quantity' => 'required',
            // 'harga' => 'required',
            // 'image' => 'required',
            'description' => 'nullable',
        ]);

        // dd($request->location);
        try {
            
            $asset_management = new AssetManagements();
            $asset_management->nama = $validateData['nama'];
            // $asset_management->quantity = $validateData['quantity'];
            // $asset_management->harga = $replaceComma;
            $asset_management->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/asset-management/');
                $image->move($destinationPath, $name);
                $asset_management->image = $name;
            }
            
            $asset_management->save();
            
            
            $assetManagementDetail = [];
            if ($request->location) {

                $replaceComma = str_replace(',', '',$request->harga);

                foreach ($request->location as $key => $value) {
                    $assetManagementDetail[] = [
                        'asset_management_id' => $asset_management->id,
                        'location' => $request->location[$key],
                        'qty' => $request->qty[$key],
                        'harga' => $replaceComma[$key],
                    ];
                }
                AssetManagementDetail::insert($assetManagementDetail);
            }

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
            'harga' => 'required',
            'image' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $replaceComma = str_replace(',', '',$request->harga);

            $asset_management = AssetManagements::findOrFail($id);
            $asset_management->nama = $validateData['nama'];
            $asset_management->quantity = $validateData['quantity'];
            $asset_management->harga = $replaceComma;
            $asset_management->description = $validateData['description'];
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/asset-management/');
                $image->move($destinationPath, $name);
                $asset_management->image = $name;
            }

            
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
