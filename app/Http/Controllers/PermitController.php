<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Permit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data['permits'] = Permit::orderby('id', 'asc')->get();

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
            'status' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $permit = new Permit();
            $permit->user_id =  auth()->user()->id;
            $permit->action = $validateData['action'];
            $permit->page = $validateData['page'];
            $permit->datetime = $validateData['datetime'];
            $permit->status = $validateData['status'];
            $permit->description = $validateData['description'];

            $permit->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Permit';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stok-masuk.index')->with(['success' => 'Permit Berhasil Terkirim!']);
        } catch (\Throwable $th) {
            return redirect()->route('stok-masuk.index')->with(['failed' => 'Permit Gagal Terkirim! '.$th->getMessage()]);
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
            'permissions' => 'required',
        ]);
        try {
            
            $permit = Permit::findorFail($id);
            // $permit->user_id =  auth()->user()->id;
            $permit->action = $validateData['action'];
            $permit->page = $validateData['page'];
            $permit->datetime = $validateData['datetime'];
            $permit->status = $validateData['status'];
            $permit->description = $validateData['description'];
            
            $user = User::where('id', $permit->user_id)->first();
            // dd($user);
            $role_id = $user->roles->first()->id;
            $role = Role::where('id', $role_id)->first();

            // dd($role_id, $role);
            $role->syncPermissions($validateData['permissions']);

            $permit->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Permit';
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
}
