<?php

namespace App\Http\Controllers;

use App\Models\BannerDineIn;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BannerDineInController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:banner-dine-in-list', ['only' => 'index']);
        $this->middleware('permission:banner-dine-in-create', ['only' => ['create','store']]);
        $this->middleware('permission:banner-dine-in-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:banner-dine-in-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Banner Dine In / Takeaway';
        $data['banners'] = BannerDineIn::orderby('id', 'asc')->get();

        return view('management-toko-online.banner-dine-in.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Media Advertising';
        $data['banner'] = BannerDineIn::get();

        return view('management-toko-online.banner-dine-in.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'description' => 'nullable',
        ]);

        try {
            $banner = new BannerDineIn();
            $banner->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/banner-dine-in/');
                $image->move($destinationPath, $name);
                $banner->image = $name;
            }

            $banner->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Media Advertising '.$banner->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('banner-dine-in.index')->with(['success' => 'Banner Dine In added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('banner-dine-in.index')->with(['failed' => 'Banner Dine In added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Media Advertising';
        $data['banner'] = BannerDineIn::find($id);

        return view('management-toko-online.banner-dine-in.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'description' => 'nullable',
        ]);

        try {
            $banner = BannerDineIn::findOrFail($id);
            $banner->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/banner-dine-in/');
                $image->move($destinationPath, $name);
                $banner->image = $name;
            }

            $banner->save();

            return redirect()->route('banner-dine-in.index')->with(['success' => 'Banner Dine In edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('banner-dine-in.index')->with(['failed' => 'Banner Dine In edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $banner = BannerDineIn::findOrFail($id);
            $banner->delete();
        });

        Session::flash('success', 'Banner deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
