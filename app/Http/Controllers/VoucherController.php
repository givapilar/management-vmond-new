<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VoucherController extends Controller
{
    function __construct()
    {
        
    }
    public function index()
    {
        $data['page_title'] = 'Voucher';
        $data['vouchers'] = Voucher::orderby('id', 'desc')->get();
        
        return view('master-data.voucher.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Tags';
        $data['tag'] = Voucher::orderBy('position', 'ASC')->get();

        return view('master-data.tag.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'code' => 'required',
            'discount' => 'nullable',
            'harga' => 'nullable',
            'minimum_transaksi' => 'nullable',
        ]);

        try {
            $voucher = new Voucher();
            $voucher->code = $validateData['code'];
            $voucher->discount = $validateData['discount'];
            $voucher->harga = $validateData['harga'];
            $voucher->minimum_transaksi = $validateData['minimum_transaksi'];
            
            $voucher->save();

            // $newHistoryLog = new HistoryLog();
            // $newHistoryLog->datetime = date('Y-m-d H:i:s');
            // $newHistoryLog->type = 'Add';
            // $newHistoryLog->menu = 'Add Voucher '.$voucher->tag_nama;
            // $newHistoryLog->user_id = auth()->user()->id;
            // $newHistoryLog->save();

            return redirect()->route('voucher.index')->with(['success' => 'Voucher added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('voucher.index')->with(['failed' => 'Voucher added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Voucher';
        $data['Voucher'] = Voucher::find($id);

        return view('master-data.voucher.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'code' => 'required',
            'discount' => 'nullable',
            'harga' => 'nullable',
            'minimum_transaksi' => 'nullable',
        ]);

        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->code = $validateData['code'];
            $voucher->discount = $validateData['discount'];
            $voucher->harga = $validateData['harga'];
            $voucher->minimum_transaksi = $validateData['minimum_transaksi'];

            $voucher->save();

            // $newHistoryLog = new HistoryLog();
            // $newHistoryLog->datetime = date('Y-m-d H:i:s');
            // $newHistoryLog->type = 'Edit';
            // $newHistoryLog->menu = 'Edit Tag '.$tag->tag_name;
            // $newHistoryLog->user_id = auth()->user()->id;
            // $newHistoryLog->save();

            return redirect()->route('voucher.index')->with(['success' => 'Voucher edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('voucher.index')->with(['failed' => 'Voucher edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();

            // $newHistoryLog = new HistoryLog();
            // $newHistoryLog->datetime = date('Y-m-d H:i:s');
            // $newHistoryLog->type = 'Delete';
            // $newHistoryLog->menu = 'Delete Tag '.$tag->tag_nama;
            // $newHistoryLog->user_id = auth()->user()->id;
            // $newHistoryLog->save();
        });
        
        Session::flash('success', 'Voucher deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
