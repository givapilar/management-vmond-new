<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:departement-list', ['only' => 'index']);
        // $this->middleware('permission:departement-create', ['only' => ['create','store']]);
        // $this->middleware('permission:departement-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:departement-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Restaurant';
        $data['restaurants'] = Restaurant::orderby('id', 'asc')->get();

        return view('management-toko-online.restaurant.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Menu';
        $data['restaurant'] = Restaurant::get();

        return view('management-vmond.restaurant.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'category' => 'required',
            'harga' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $restaurant = new Restaurant();
            $restaurant->nama = $validateData['nama'];
            $restaurant->slug = $slug;
            $restaurant->category = $validateData['category'];
            $restaurant->harga = $validateData['harga'];
            $restaurant->status = $validateData['status'];
            $restaurant->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/restaurant/');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }

            $restaurant->save();

            return redirect()->route('restaurant.index')->with(['success' => 'Restaurant added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('restaurant.index')->with(['failed' => 'Restaurant added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Menu';
        $data['restaurant'] = Restaurant::findorFail($id);

        return view('management-toko-online.restaurant.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'category' => 'required',
            'harga' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->nama = $validateData['nama'];
            $restaurant->slug = $slug;
            $restaurant->category = $validateData['category'];
            $restaurant->harga = $validateData['harga'];
            $restaurant->status = $validateData['status'];
            $restaurant->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/restaurant/');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }

            $restaurant->save();

            return redirect()->route('restaurant.index')->with(['success' => 'Restaurant edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('restaurant.index')->with(['failed' => 'Restaurant edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();
        });

        Session::flash('success', 'Restaurant deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function getApiResto(){
        $dataResto = Restaurant::get();

        return $dataResto;
    }
}
