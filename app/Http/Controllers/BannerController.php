<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:banner-index', ['only' => 'index']);
        $this->middleware('permission:banner-create', ['only' => ['create','store']]);
        $this->middleware('permission:banner-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Banner';
        $data['banners'] = Banner::orderby('id', 'asc')->get();
        
        return view('management-toko-online.banner.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Banner';
        $data['banner'] = Banner::get();

        return view('management-toko-online.banner.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $banner = new Banner();
            $banner->description = $validateData['description'];
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/banner/');
                $image->move($destinationPath, $name);
                $banner->image = $name;
            }

            $banner->save();

            return redirect()->route('banner.index')->with(['success' => 'Banner added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('banner.index')->with(['failed' => 'Banner added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Banner';
        $data['banner'] = Banner::find($id);

        return view('management-toko-online.banner.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $banner = Banner::findOrFail($id);
            $banner->description = $validateData['description'];
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/banner/');
                $image->move($destinationPath, $name);
                $banner->image = $name;
                // dd($banner->image = $name);
            }

            $banner->save();

            return redirect()->route('banner.index')->with(['success' => 'Banner edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('banner.index')->with(['failed' => 'Banner edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $banner = Banner::findOrFail($id);
            $banner->delete();
        });
        
        Session::flash('success', 'Banner deleted successfully!');
        return response()->json(['status' => '200']);
    }   
}
