<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\HistoryLog;
use App\Models\Restaurant;
use App\Models\RestaurantAddOn;
use App\Models\RestaurantPivots;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;
// Use Image;
use Intervention\Image\Facades\Image;

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
        $data['add_ons'] = AddOn::get();

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
            'harga_diskon' => 'nullable',
            'persentase' => 'nullable',
            'stok_perhari' => 'nullable',
            'current_stok' => 'nullable',
            'tag_id' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $replaceTitik = str_replace(',', '',$request->harga);
            $replaceTitikHarga = str_replace(',', '',$request->harga_diskon);

            $restaurant = new Restaurant();
            $restaurant->nama = $validateData['nama'];
            $restaurant->slug = $slug;
            $restaurant->category = $validateData['category'];
            $restaurant->harga = $replaceTitik;
            $restaurant->harga_diskon = $replaceTitikHarga;
            $restaurant->persentase = $validateData['persentase'];
            $restaurant->stok_perhari = $validateData['stok_perhari'];
            $restaurant->current_stok = $validateData['current_stok'];
            $restaurant->status = $validateData['status'];
            $restaurant->description = $validateData['description'];
            $restaurant->code = 0;

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $name = time() . '.' . $image->getClientOriginalExtension();
            //     $destinationPath = public_path('assets/images/restaurant/');
            //     $image->move($destinationPath, $name);
            //     $restaurant->image = $name;
            // }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/restaurant/'.$filename;

                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
                    return redirect()->route('restaurant.index')->with(['failed' => 'Image Size 200 x 200!']);

                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);

                    // Save the resized image
                    $img->save(public_path($filePath));

                    // Store the image filename in the restaurant model
                    $restaurant->image = basename($filePath);
                    // If the image dimensions or weight do not meet the requirements, store the original image path
                }
            }

            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Restaurant '.$restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $restaurantTags = [];
            if ($request->tag_id) {
                $restaurantTags = [];
                foreach ($request->tag_id as $key => $value) {

                    $restaurantTags[] = [
                        'restaurant_id' => $restaurant->id,
                        'tag_id' => $request->tag_id[$key],
                        'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantPivots::insert($restaurantTags);
            }

            if ($request->add_on_id) {
                $restaurantAddOn = [];
                foreach ($request->add_on_id as $key => $value) {

                    $restaurantAddOn[] = [
                        'restaurant_id' => $restaurant->id,
                        'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantPivots::insert($restaurantAddOn);
            }

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
        $data['add_ons'] = AddOn::get();
        $data['restaurant_tags'] = RestaurantPivots::where("restaurant_id",$id)
        ->pluck('tag_id')
        ->all();

        $data['restaurant_add_on'] = RestaurantPivots::where("restaurant_id",$id)
        ->pluck('add_on_id')
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
            'harga_diskon' => 'nullable',
            'persentase' => 'nullable',
            'stok_perhari' => 'nullable',
            'current_stok' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);
        // dd($request->all());

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $replaceTitik = str_replace(',', '',$request->harga);
            // $replaceComma = substr($replaceTitik, 0 , -3);

            $replaceTitikHarga = str_replace(',', '',$request->harga_diskon);
            // $replaceCommaHarga = substr($replaceTitikHarga, 0 , -3);

            $restaurant = Restaurant::findOrFail($id);

            $restaurant->nama = $validateData['nama'];
            $restaurant->slug = $slug;
            $restaurant->category = $validateData['category'];
            $restaurant->harga = $replaceTitik;
            $restaurant->harga_diskon = $replaceTitikHarga;
            $restaurant->persentase = $validateData['persentase'];
            $restaurant->stok_perhari = $validateData['stok_perhari'];
            $restaurant->current_stok = $validateData['current_stok'];
            $restaurant->status = $validateData['status'];
            $restaurant->description = $validateData['description'];
            $restaurant->code = 0;

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $name = time() . '.' . $image->getClientOriginalExtension();
            //     $destinationPath = public_path('assets/images/restaurant/');
            //     $image->move($destinationPath, $name);
            //     $restaurant->image = $name;
            // }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/restaurant/'.$filename;

                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
                    return redirect()->route('restaurant.index')->with(['failed' => 'Image Size 200 x 200!']);
                    // return 'Image Harus format 200 x 200!';

                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);

                    // Save the resized image
                    $img->save(public_path($filePath));

                    // Store the image filename in the restaurant model
                    $restaurant->image = basename($filePath);
                    // If the image dimensions or weight do not meet the requirements, store the original image path
                }
            }

            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Restaurant '.$restaurant->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $restaurant->restaurantTag()->delete();

            if ($request->tag_id && $request->add_on_id) {
                $restaurantTags = [];
                foreach ($request->tag_id as $key => $value) {

                    $restaurantTags[] = [
                        'restaurant_id' => $restaurant->id,
                        'tag_id' => $request->tag_id[$key],
                        'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantPivots::insert($restaurantTags);
            }

            if ($request->add_on_id && $request->add_on_id) {
                $restaurantAddOn = [];
                foreach ($request->add_on_id as $key => $value) {

                    $restaurantAddOn[] = [
                        'restaurant_id' => $restaurant->id,
                        'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantAddOn::insert($restaurantAddOn);
            }

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
