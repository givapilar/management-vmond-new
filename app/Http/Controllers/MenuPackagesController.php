<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use App\Models\HistoryLog;
use App\Models\MeetingRoom;
use App\Models\MenuPackagePivots;
use App\Models\MenuPackages;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class MenuPackagesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:paket-menu-list', ['only' => 'index']);
        $this->middleware('permission:paket-menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:paket-menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:paket-menu-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Paket Menu';
        $data['menu_packages'] = MenuPackages::orderBy('id', 'ASC')->get();
        $data['menu_package_pivots'] = MenuPackagePivots::get();
        $data['restaurants'] = Restaurant::get();
        $data['billiards'] = Biliard::get();
        $data['meeting_rooms'] = MeetingRoom::get();
        return view('management-toko-online.paket-menu.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate( [
            'nama_paket' => 'required',
            'category' => 'required',
            'harga' => 'required',
            'harga_diskon' => 'nullable',
            'persentase' => 'nullable',
            'restaurant_id' => 'required',
            'billiard_id' => 'nullable|required_if:category,billiard',
            'meeting_room_id' => 'nullable|required_if:category,meeting_room',
            'status' => 'required',
            'minimal' => 'required',
            'jam' => 'required',
            'status_konfirmasi' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);


        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama_paket']));
            $harga = str_replace(',', '',$validateData['harga']);
            $harga_diskon = str_replace(',', '',$validateData['harga_diskon']);

            $paket_menu = new MenuPackages();
            $paket_menu->nama_paket = $validateData['nama_paket'];
            $paket_menu->slug = $slug;
            $paket_menu->category = $validateData['category'];
            $paket_menu->harga = $harga;
            $paket_menu->harga_diskon = $harga_diskon;
            $paket_menu->persentase = $validateData['persentase'];
            $paket_menu->status = $validateData['status'];
            $paket_menu->minimal = $validateData['minimal'];
            $paket_menu->status_konfirmasi = $validateData['status_konfirmasi'];
            $paket_menu->description = $validateData['description'];
            $paket_menu->jam = $validateData['jam'];
            $paket_menu->billiard_id = $validateData['billiard_id'] ?? null;
            $paket_menu->room_meeting_id = $validateData['meeting_room_id'] ?? null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/paket-menu/'.$filename;

                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    return redirect()->route('paket-menu.index')->with(['failed' => 'Image Size 200 x 200!']);
                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);

                    // Save the resized image
                    $img->save(public_path($filePath));

                    // Store the image filename in the paket-menu model
                    $paket_menu->image = basename($filePath);
                }
            }

            $paket_menu->save();

            if ($request->restaurant_id) {
                $restaurants = [];
                foreach ($request->restaurant_id as $key => $value) {
                    $restaurants[] = [
                        'menu_packages_id' => $paket_menu->id,
                        'restaurant_id' => $request->restaurant_id[$key],
                    ];
                }
                MenuPackagePivots::insert($restaurants);
            }

            // History Log Record
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Paket Menu: '.$paket_menu->nama_paket;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('paket-menu.index')->with(['success' => 'Paket Menu added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('paket-menu.index')->with(['failed' => 'Paket Menu added failed! '.$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function show(MenuPackages $menuPackages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Paket Menu';
        $data['package'] = MenuPackages::findorFail($id);
        $data['restaurants'] = Restaurant::get();
        $data['billiards'] = Biliard::get();
        $data['meeting_rooms'] = MeetingRoom::get();
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();

        return view('management-toko-online.paket-menu.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate( [
            'nama_paket' => 'required',
            'category' => 'required',
            'harga' => 'required',
            'harga_diskon' => 'nullable',
            'persentase' => 'nullable',
            'restaurant_id' => 'required',
            'billiard_id' => 'nullable|required_if:category,billiard',
            'meeting_room_id' => 'nullable|required_if:category,meeting_room',
            'status' => 'required',
            'minimal' => 'required',
            'status_konfirmasi' => 'required',
            'jam' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama_paket']));
            $harga = str_replace(',', '',$validateData['harga']);
            $harga_diskon = str_replace(',', '',$validateData['harga_diskon']);

            $paket_menu = MenuPackages::findorFail($id);
            $paket_menu->nama_paket = $validateData['nama_paket'];
            $paket_menu->slug = $slug;
            $paket_menu->category = $validateData['category'];
            $paket_menu->harga = $harga;
            $paket_menu->harga_diskon = $harga_diskon;
            $paket_menu->persentase = $validateData['persentase'];
            $paket_menu->status = $validateData['status'];
            $paket_menu->minimal = $validateData['minimal'];
            $paket_menu->jam = $validateData['jam'];
            $paket_menu->status_konfirmasi = $validateData['status_konfirmasi'];
            $paket_menu->description = $validateData['description'];
            $paket_menu->billiard_id = $validateData['billiard_id'] ?? null;
            $paket_menu->room_meeting_id = $validateData['meeting_room_id'] ?? null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/paket-menu/'.$filename;

                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    return redirect()->route('paket-menu.index')->with(['failed' => 'Image Size 200 x 200!']);
                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);

                    // Save the resized image
                    $img->save(public_path($filePath));

                    // Store the image filename in the paket-menu model
                    $paket_menu->image = basename($filePath);
                }
            }

            $paket_menu->save();

            $paket_menu->MenuPackagePivots()->delete();

            if ($request->restaurant_id) {
                $restaurants = [];
                foreach ($request->restaurant_id as $key => $value) {
                    $restaurants[] = [
                        'menu_packages_id' => $paket_menu->id,
                        'restaurant_id' => $request->restaurant_id[$key],
                    ];
                }
                MenuPackagePivots::insert($restaurants);
            }


            // History Log Record
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Paket Menu: '.$paket_menu->nama_paket;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('paket-menu.index')->with(['success' => 'Paket Menu edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('paket-menu.index')->with(['failed' => 'Paket Menu edited failed! '.$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuPackages  $menuPackages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $paket_menu = MenuPackages::findOrFail($id);
            $paket_menu->MenuPackagePivots()->delete();
            $paket_menu->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Paket Menu: '.$paket_menu->nama_paket;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Paket Menu deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
