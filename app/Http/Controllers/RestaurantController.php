<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Restaurant;
use App\Models\RestaurantPivots;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:restaurant-list', ['only' => 'index']);
        $this->middleware('permission:restaurant-create', ['only' => ['create','store']]);
        $this->middleware('permission:restaurant-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:restaurant-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Restaurant';
        $data['restaurants'] = Restaurant::orderby('id', 'asc')->get();
        $data['restaurant_pivots'] = RestaurantPivots::get();
        $data['tags'] = Tags::get();

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
            'harga_diskon' => 'required',
            'stok_perhari' => 'required',
            'current_stok' => 'nullable',
            'tag_id' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $replaceTitik = str_replace('.', '',$request->harga);
            $replaceComma = substr($replaceTitik, 0 , -3);

            $replaceTitikHarga = str_replace('.', '',$request->harga_diskon);
            $replaceCommaHarga = substr($replaceTitikHarga, 0 , -3);

            $restaurant = new Restaurant();
            $restaurant->nama = $validateData['nama'];
            $restaurant->slug = $slug;
            $restaurant->category = $validateData['category'];
            $restaurant->harga = $replaceComma;
            $restaurant->harga_diskon = $replaceCommaHarga;
            $restaurant->stok_perhari = $validateData['stok_perhari'];
            $restaurant->current_stok = $validateData['current_stok'];
            $restaurant->status = $validateData['status'];
            $restaurant->description = $validateData['description'];
            $restaurant->code = 0;
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/restaurant/');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }
            
            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Restaurant '.$restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
            
            $restaurantTags = [];
            foreach ($request->tag_id as $key => $value) {

                $restaurantTags[] = [
                    'restaurant_id' => $restaurant->id,
                    'tag_id' => $request->tag_id[$key],
                ];
            }
            RestaurantPivots::insert($restaurantTags);
            
            
            if ($restaurant->category == 'Makanan') {
                $restaurant->code = $this->getNextId('MKN', $restaurant->id) ;
            }else{
                $restaurant->code = $this->getNextId('MNM', $restaurant->id);
            }

            return redirect()->route('restaurant.index')->with(['success' => 'Restaurant added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('restaurant.index')->with(['failed' => 'Restaurant added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Menu';
        $data['restaurant'] = Restaurant::findorFail($id);
        $data['tags'] = Tags::get();
        $data['restaurant_tags'] = RestaurantPivots::where("restaurant_id",$id)
        ->pluck('tag_id')
        ->all();

        return view('management-toko-online.restaurant.edit',$data);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'category' => 'required',
            'harga' => 'required',
            'harga_diskon' => 'required',
            'stok_perhari' => 'required',
            'current_stok' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $replaceTitik = str_replace('.', '',$request->harga);
            $replaceComma = substr($replaceTitik, 0 , -3);

            $replaceTitikHarga = str_replace('.', '',$request->harga_diskon);
            $replaceCommaHarga = substr($replaceTitikHarga, 0 , -3);

            $restaurant = Restaurant::findOrFail($id);
            
            $restaurant->nama = $validateData['nama'];
            $restaurant->slug = $slug;
            $restaurant->category = $validateData['category'];
            $restaurant->harga = $replaceComma;
            $restaurant->harga_diskon = $replaceCommaHarga;
            $restaurant->stok_perhari = $validateData['stok_perhari'];
            $restaurant->current_stok = $validateData['current_stok'];
            $restaurant->status = $validateData['status'];
            $restaurant->description = $validateData['description'];
            $restaurant->code = 0;
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/restaurant/');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }
            
            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Restaurant '.$restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $restaurant->restaurantTag()->delete();

            $restaurantTags = [];
            foreach ($request->tag_id as $key => $value) {

                $restaurantTags[] = [
                    'restaurant_id' => $restaurant->id,
                    'tag_id' => $request->tag_id[$key],
                ];
            }
            RestaurantPivots::insert($restaurantTags);
            
            if ($restaurant->category == 'Makanan') {
                $restaurant->code = $this->getNextId('MKN', $restaurant->id) ;
            }else{
                $restaurant->code = $this->getNextId('MNM', $restaurant->id);
            }
            

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

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Restaurant '.$restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Restaurant deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function getNextId($category, $id){
        DB::table('restaurants')->where('id', $id)->update(['code' => $category.$id]);
        return 0;
    }   

    public function getApiResto(){
        $dataResto = Restaurant::get();

        return $dataResto;
    }
}
