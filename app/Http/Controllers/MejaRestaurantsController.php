<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\MejaRestaurants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MejaRestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // $this->middleware('permission:restaurant-list', ['only' => 'index']);
        // $this->middleware('permission:restaurant-create', ['only' => ['create','store']]);
        // $this->middleware('permission:restaurant-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:restaurant-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Meja Restaurant';
        $data['meja_restaurants'] = MejaRestaurants::orderby('id', 'asc')->get();

        return view('master-data.meja-restaurant.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Menu';
        $data['meja_restaurant'] = MejaRestaurants::get();

        return view('master-data.meja-restaurant.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'category' => 'required',
            'status' => 'required',
            'description' => 'nullable',
        ]);

        try {

            $meja_restaurant = new MejaRestaurants();
            $meja_restaurant->nama = $validateData['nama'];
            $meja_restaurant->category = $validateData['category'];
            $meja_restaurant->status = $validateData['status'];
            $meja_restaurant->description = $validateData['description'];
            
            $meja_restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Meja Restaurant '.$meja_restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
            
            return redirect()->route('meja-restaurant.index')->with(['success' => 'Meja Restaurant added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('meja-restaurant.index')->with(['failed' => 'Meja Restaurant added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Menu';
        $data['meja_restaurant'] = MejaRestaurants::findorFail($id);

        return view('master-data.meja-restaurant.edit',$data);
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'category' => 'required',
            'status' => 'required',
            'description' => 'nullable',
        ]);

        try {

            $meja_restaurant = MejaRestaurants::findOrFail($id);
            
            $meja_restaurant->nama = $validateData['nama'];
            $meja_restaurant->status = $validateData['status'];
            $meja_restaurant->category = $validateData['category'];
            $meja_restaurant->description = $validateData['description'];
            
            $meja_restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Meja Restaurant '.$meja_restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('meja-restaurant.index')->with(['success' => 'Meja Restaurant edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('meja-restaurant.index')->with(['failed' => 'Meja Restaurant edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $restaurant = MejaRestaurants::findOrFail($id);
            $restaurant->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Meja Restaurant '.$restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Meja Restaurant deleted successfully!');
        return response()->json(['status' => '200']);
    }

}
