<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\LinkPermit;
use App\Models\Material;
use App\Models\Permit;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Permit';
        if(Auth::user()->can('permit-edit')){
            $data['permits'] = Permit::orderby('id', 'asc')->get();
        }else{
            $data['permits'] = Permit::orderby('id', 'asc')->where('user_id', Auth::user()->id)->get();
        }

        return view('permit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'action' => 'required',
            'page' => 'required',
            'datetime' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $permit = new Permit();
            $permit->user_id =  auth()->user()->id;
            $permit->action = $validateData['action'];
            $permit->page = $validateData['page'];
            $permit->datetime = $validateData['datetime'];
            $permit->id_stock = $request->id_stock;
            $permit->status = 'Dalam Proses';
            $permit->description = $validateData['description'];

            $permit->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Permit';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->back()->with(['success' => 'Permit Berhasil Terkirim!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['failed' => 'Permit Gagal Terkirim! '.$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function show(Permit $permit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
    {
        $data['page_title'] = 'Edit Permit';
        // $data['permits'] = Permit::find($id);
        $data['permits'] = Permit::find($id);
        $data['permissions'] = Permission::get();
        $role = DB::table("model_has_roles")
        ->where("model_has_roles.model_id",$data['permits']->user_id)
        ->pluck('model_has_roles.role_id')
        ->all();
        $data['rolePermissions'] = DB::table("role_has_permissions")
        ->where("role_has_permissions.role_id",$role)
        ->pluck('role_has_permissions.permission_id')
        ->all();

        // dd($data);

        return view('permit.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validateData = $request->validate([
            'action' => 'required',
            'page' => 'required',
            'datetime' => 'required',
            'status' => 'required',
            'description' => 'nullable',
            'link' => 'nullable',
            'note' => 'nullable',
            // 'permissions' => 'required',
        ]);
        try {

            $permit = Permit::findorFail($id);
            $permit->action = $validateData['action'];
            $permit->page = $validateData['page'];
            $permit->datetime = $validateData['datetime'];
            $permit->status = $validateData['status'];
            $permit->description = $validateData['description'];
            $permit->note = $validateData['note'] ?? null;

            if ($request->status == 'Disetujui') {
                $jsonData = [
                    'idPermit' => $id,
                    'userId' => $permit->user_id,
                    'id_stock' => $permit->id_stock,
                    'page' => $permit->page
                ];
                $dataEncode = Crypt::encryptString(json_encode($jsonData));

                $link_permit = new LinkPermit();
                if ($permit->action == 'edit') {
                    $link_permit->link = route('editByPermit', ['token' => $dataEncode]);
                } else if($permit->action == 'delete'){
                    $link_permit->link = route('deleteByPermit', ['token' => $dataEncode]);
                }

                $link_permit->status = true;
                $link_permit->save();
                $permit->link_id = $link_permit->id;
            }else{
                $permit->link_id =  null;
            }

            $permit->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Update';
            $newHistoryLog->menu = 'Update Permit';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('permit.index')->with(['success' => 'Permit Berhasil Terkirim!']);
        } catch (\Throwable $th) {
            return redirect()->route('permit.index')->with(['failed' => 'Permit Gagal Terkirim! '.$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permit $permit)
    {
        //
    }

    public function editDataByPermit($token){
        $decryptedData = Crypt::decryptString($token);
        $jsonData = json_decode($decryptedData, true);
        $auth = Auth::user()->id ?? null;
        $permit = Permit::findorFail($jsonData['idPermit']);
        $link_permit = LinkPermit::findOrFail($permit->link_id);
        $data['page_title'] = strtoupper('Edit '.$jsonData['page'].' By Permit') ;
        $data['token'] = $token;

        // Different user access
        if($auth != $jsonData['userId']){
            return redirect()->route('permit.index')->with(['failed' => 'Invalid user. Please provide a valid user!']);
        }

         // Link is already in use
         if($link_permit->status == false){
            return redirect()->route('permit.index')->with(['failed' => 'The requested link could not be found.']);
        }

        if($jsonData['page'] == 'Stok Masuk'){
            $data['materials'] = Material::get();
            $data['stok_masuk'] = StokMasuk::findOrFail($jsonData['id_stock']);

            return view('inventory.stok-masuk.action-edit-by-permit', $data);
        }elseif($jsonData['page'] == 'Stok Keluar'){
            $data['materials'] = Material::get();
            $data['stok_keluar'] = StokKeluar::findOrFail($jsonData['id_stock']);

            return view('inventory.stok-keluar.action-edit-by-permit', $data);
        }

    }

    public function updateDataByPermit(Request $request, $token){
        $decryptedData = Crypt::decryptString($token);
        $jsonData = json_decode($decryptedData, true);
        $auth = Auth::user()->id;
        $permit = Permit::findorFail($jsonData['idPermit']);
        $link_permit = LinkPermit::findOrFail($permit->link_id);

        // Different user access
        if($auth != $jsonData['userId']){
            return redirect()->route('permit.index')->with(['failed' => 'Invalid user. Please provide a valid user!']);
        }

        // Link is already in use
        if($link_permit->status == false){
            return redirect()->route('permit.index')->with(['failed' => 'The requested link could not be found.']);
        }

        if($jsonData['page'] == 'Stok Masuk'){
            $validateData = $request->validate([
                'material_id' => 'required',
                'material_masuk' => 'required',
                'description' => 'nullable',
            ]);
            try {
                $stockin = StokMasuk::findOrFail($jsonData['id_stock']);
                $stockin->material_id = $validateData['material_id'];
                $stockin->material_masuk = $validateData['material_masuk'];
                $stockin->description = $validateData['description'];

                $stockin->save();

                $link_permit->status = 'false';
                $link_permit->save();

                $newHistoryLog = new HistoryLog();
                $newHistoryLog->datetime = date('Y-m-d H:i:s');
                $newHistoryLog->type = 'Edit';
                $newHistoryLog->menu = '(Permit) Edit Stok Masuk '.$stockin->material->nama;
                $newHistoryLog->user_id = auth()->user()->id;
                $newHistoryLog->save();
            } catch (\Throwable $th) {
                return redirect()->back()->with(['failed' => $th->getMessage()]);
            }

        }elseif($jsonData['page'] == 'Stok Keluar'){
            $validateData = $request->validate([
                'material_id' => 'required',
                'material_keluar' => 'required',
                'description' => 'nullable',
            ]);

            try {
                $stockout = StokKeluar::findOrFail($jsonData['id_stock']);
                $stockout->material_id = $validateData['material_id'];
                $stockout->material_keluar = $validateData['material_keluar'];
                $stockout->description = $validateData['description'];

                $stockout->save();

                $link_permit->status = 'false';
                $link_permit->save();

                $newHistoryLog = new HistoryLog();
                $newHistoryLog->datetime = date('Y-m-d H:i:s');
                $newHistoryLog->type = 'Edit';
                $newHistoryLog->menu = '(Permit) Edit Stok Keluar '.$stockout->material->nama;
                $newHistoryLog->user_id = auth()->user()->id;
                $newHistoryLog->save();
            } catch (\Throwable $th) {
                return redirect()->back()->with(['failed' => $th->getMessage()]);
            }
        }

        return redirect()->route('permit.index')->with(['success' => $jsonData['page'].' Edited Successfully!']);
    }

    public function deleteViewDataByPermit($token){
        $decryptedData = Crypt::decryptString($token);
        $jsonData = json_decode($decryptedData, true);
        $auth = Auth::user()->id ?? null;
        $permit = Permit::findorFail($jsonData['idPermit']);
        $link_permit = LinkPermit::findOrFail($permit->link_id);
        $data['page_title'] = strtoupper('Delete '.$jsonData['page'].' By Permit') ;
        $data['token'] = $token;

        // Different user access
        if($auth != $jsonData['userId']){
            return redirect()->route('permit.index')->with(['failed' => 'Invalid user. Please provide a valid user!']);
        }

         // Link is already in use
         if($link_permit->status == false){
            return redirect()->route('permit.index')->with(['failed' => 'The requested link could not be found.']);
        }

        if($jsonData['page'] == 'Stok Masuk'){
            $data['materials'] = Material::get();
            $data['stok_masuk'] = StokMasuk::findOrFail($jsonData['id_stock']);

            return view('inventory.stok-masuk.action-delete-by-permit', $data);
        }elseif($jsonData['page'] == 'Stok Keluar'){
            $data['materials'] = Material::get();
            $data['stok_keluar'] = StokKeluar::findOrFail($jsonData['id_stock']);

            return view('inventory.stok-keluar.action-delete-by-permit', $data);
        }
    }

    public function DeleteDataByPermit($token){
        $decryptedData = Crypt::decryptString($token);
        $jsonData = json_decode($decryptedData, true);
        $auth = Auth::user()->id;
        $permit = Permit::findorFail($jsonData['idPermit']);
        $link_permit = LinkPermit::findOrFail($permit->link_id);

        // Different user access
        if($auth != $jsonData['userId']){
            return redirect()->route('permit.index')->with(['failed' => 'Invalid user. Please provide a valid user!']);
        }

        // Link is already in use
        if($link_permit->status == false){
            return redirect()->route('permit.index')->with(['failed' => 'The requested link could not be found.']);
        }

        if($jsonData['page'] == 'Stok Masuk'){
            try {
                DB::transaction(function () use ($jsonData) {
                    $stok_masuk = StokMasuk::findOrFail($jsonData['id_stock']);

                    $newHistoryLog = new HistoryLog();
                    $newHistoryLog->datetime = date('Y-m-d H:i:s');
                    $newHistoryLog->type = 'Delete';
                    $newHistoryLog->menu = '(Permit) Delete Stok Masuk '.$stok_masuk->material->nama;
                    $newHistoryLog->user_id = auth()->user()->id;
                    $newHistoryLog->save();

                    $stok_masuk->delete();
                });

                $link_permit->status = 'false';
                $link_permit->save();
            } catch (\Throwable $th) {
                return redirect()->back()->with(['failed' => $th->getMessage()]);
            }

        }elseif($jsonData['page'] == 'Stok Keluar'){
            try {
                DB::transaction(function () use ($jsonData) {
                    $stok_keluar = StokKeluar::findOrFail($jsonData['id_stock']);

                    $newHistoryLog = new HistoryLog();
                    $newHistoryLog->datetime = date('Y-m-d H:i:s');
                    $newHistoryLog->type = 'Delete';
                    $newHistoryLog->menu = '(Permit) Delete Stok Keluar '.$stok_keluar->material->nama;
                    $newHistoryLog->user_id = auth()->user()->id;
                    $newHistoryLog->save();

                    $stok_keluar->delete();
                });

                $link_permit->status = 'false';
                $link_permit->save();
            } catch (\Throwable $th) {
                return redirect()->back()->with(['failed' => $th->getMessage()]);
            }
        }

        return redirect()->route('permit.index')->with(['success' => $jsonData['page'].' Delete Successfully!']);
    }
}
