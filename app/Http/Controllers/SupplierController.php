<?php

namespace App\Http\Controllers;

use App\Models\DetailSupplier;
use App\Models\HistoryLog;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Supplier List';
        $data['suppliers'] = Supplier::get();

        return view('master-data.supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'name' => 'required',
            // 'quantity' => 'required',
            // 'harga' => 'required',
            // 'image' => 'required',
            'description' => 'nullable',
        ]);

        // dd($request->all());
        try {
            
            $supplier = new Supplier();
            $supplier->name = $validateData['name'];
            // $supplier->description = $validateData['description']; // Uncomment this line and ensure $validateData['description'] is a string
            $supplier->save();
            
            $supplirDetail = [];
            if ($request->name_detail) {

                foreach ($request->name_detail as $key => $value) {
                    $supplirDetail[] = [
                        'supplier_id' => $supplier->id,
                        'name' => $request->name_detail[$key],
                        'telephone' => $request->telephone[$key],
                        'email' => $request->email[$key],
                        'address' => $request->address[$key],
                    ];
                }
                DetailSupplier::insert($supplirDetail);
            }

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Supplier '.$request->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('supplier.index')->with(['success' => 'Supplier added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('supplier.index')->with(['failed' => 'Supplier added failed! '.$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page_title'] = 'Edit Detail Supplier';
        $data['suppliers'] = Supplier::find($id);
        $data['supplier_details'] = DetailSupplier::get();
    
        return view('master-data.supplier.detail',$data);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Detail Supplier';
        $data['supplier'] = Supplier::find($id);
    
        return view('master-data.supplier.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        try {

            $supplier = Supplier::findOrFail($id);
            $supplier->name = $validateData['name'];
            $supplier->description = $validateData['description'];
            
            $supplier->save();

            $supplier->detailSupplier()->delete();


            if ($request->name_detail) {
                $supplierDetail = [];
                foreach ($request->name_detail as $key => $value) {

                    $supplierDetail[] = [
                        'supplier_id' => $supplier->id,
                        'name' => $request->name_detail[$key],
                        'telephone' => $request->telephone[$key],
                        'email' => $request->email[$key],
                        'address' => $request->address[$key],
                    ];
                }
                DetailSupplier::insert($supplierDetail);
            }

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Supplier '.$request->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('supplier.index')->with(['success' => 'Supplier edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('supplier.index')->with(['failed' => 'Supplier edited Failed! '. $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Supplier '.$supplier->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Asset Management deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
