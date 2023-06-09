<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Illuminate\Http\Request;
use App\Models\Membership;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MembershipController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:membership-list', ['only' => 'index']);
        $this->middleware('permission:membership-create', ['only' => ['create','store']]);
        $this->middleware('permission:membership-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:membership-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Bahan Baku';
        $data['memberships'] = Membership::orderby('id', 'asc')->get();
        
        return view('master-data.membership.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Membership';
        $data['memberships'] = Membership::get();

        return view('master-data.membership.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'level' => 'required',
            'minimum_transaksi' => 'required',
        ]);

        // dd($request->all());
        try {
            $membership = new Membership();
            $membership->level = $validateData['level'];
            $membership->minimum_transaksi = $validateData['minimum_transaksi'];
            
            $membership->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Membership '.$request->level;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('membership.index')->with(['success' => 'Membership added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('membership.index')->with(['failed' => 'Membership added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Membership';
        $data['memberships'] = Membership::find($id);

        return view('master-data.membership.edit',$data);
    }

    public function show(){
        
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'level' => 'required',
            'minimum_transaksi' => 'required',
        ]);

        try {
            $membership = Membership::findOrFail($id);
            $membership->level = $validateData['level'];
            $membership->minimum_transaksi = $validateData['minimum_transaksi'];
            

            $membership->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Membership '.$request->level;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('membership.index')->with(['success' => 'Membership edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('membership.index')->with(['failed' => 'Membership edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $membership = Membership::findOrFail($id);
            $membership->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Bahan Baku '.$membership->level;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Membership deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
