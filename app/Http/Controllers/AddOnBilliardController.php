<?php

namespace App\Http\Controllers;

use App\Models\AddOnBilliard;
use App\Models\AddOnDetailBilliard;
use App\Models\HistoryLog;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AddOnBilliardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:add-on-list', ['only' => 'index']);
        $this->middleware('permission:add-on-create', ['only' => ['create','store']]);
        $this->middleware('permission:add-on-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:add-on-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Add On Billiard List';
        $data['add_ons'] = AddOnBilliard::get();
        $data['restaurants'] = Restaurant::get();

        return view('master-data.add-on-billiard.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add On Billiard Create';
        $data['add_ons'] = AddOnBilliard::get();

        return view('master-data.add-on-billiard.create', $data);
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
            'title' => 'required',
            'minimum_choice' => 'nullable',
        ]);

        // dd($request->all());
        try {
            // dd($request->all());
            $add_on_billiard = new AddOnBilliard();
            $add_on_billiard->title = $validateData['title'];
            $add_on_billiard->minimum_choice = $validateData['minimum_choice'];
            $add_on_billiard->save();
            
            $addOnDetail = [];
            if ($request->restaurant_id) {
                foreach ($request->restaurant_id as $key => $value) {
                    $harga = $request->harga[$key];
                    $replaceComma = str_replace(',', '', $harga);

                    $addOnDetail[] = [
                        'add_on_billiard_id' => $add_on_billiard->id,
                        'restaurant_id' => $request->restaurant_id[$key],
                        'harga' => $replaceComma,
                    ];
                }
                AddOnDetailBilliard::insert($addOnDetail);
            }

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Add On Billiard'.$request->title;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('add-on-billiard.index')->with(['success' => 'Add On Billiard added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('add-on-billiard.index')->with(['failed' => 'Add On added billiard failed! '.$th->getMessage()]);
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
        $data['page_title'] = 'Edit Detail Add On';
        $data['add_ons'] = AddOnBilliard::find($id);
        $data['add_on_details'] = AddOnDetailBilliard::get();
    
        return view('master-data.add-on-billiard.detail',$data);
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
        $data['page_title'] = 'Edit Detail Add On';
        $data['add_ons'] = AddOnBilliard::find($id);
        $data['restaurants'] = Restaurant::get();
    
        return view('master-data.add-on-billiard.edit',$data);
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
            'title' => 'required',
            'minimum_choice' => 'nullable',
        ]);

        // dd($request->all());
        try {

            $add_on = AddOnBilliard::findOrFail($id);
            $add_on->title = $validateData['title'];
            $add_on->minimum_choice = $validateData['minimum_choice'];
            
            $add_on->save();

            $add_on->detailAddOnBilliard()->delete();


            if ($request->restaurant_id) {
                $addOnDetail = [];
                foreach ($request->restaurant_id as $key => $value) {
                    $harga = $request->harga[$key];
                    $replaceComma = str_replace(',', '', $harga);

                    $addOnDetail[] = [
                        'add_on_billiard_id' => $add_on->id,
                        'restaurant_id' => $request->restaurant_id[$key],
                        'harga' => $replaceComma,
                    ];
                }
                AddOnDetailBilliard::insert($addOnDetail);
            }

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Add On '.$request->title;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('add-on-billiard.index')->with(['success' => 'Add On edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('add-on-billiard.index')->with(['failed' => 'Add On edited Failed! '. $th->getMessage()]);
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
            $add_on = AddOnBilliard::findOrFail($id);
            $add_on->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Add On '.$add_on->title;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Add On deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
