<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:media-advertising-list', ['only' => 'index']);
        $this->middleware('permission:media-advertising-create', ['only' => ['create','store']]);
        $this->middleware('permission:media-advertising-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:media-advertising-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Media Advertising';
        $data['banners'] = Banner::orderby('id', 'asc')->get();

        return view('management-toko-online.banner.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Media Advertising';
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

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $filename = time().'.'.$image->getClientOriginalExtension();
            //     $filePath = 'assets/images/banner/'.$filename;
                
            //     // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
            //     if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
            //         // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
            //         return redirect()->route('media-advertising.index')->with(['failed' => 'Image Size 200 x 200!']);

            //     } else {
            //         // Resize the image
            //         $img = Image::make($image)->resize(200, 200);
                    
            //         // Save the resized image
            //         $img->save(public_path($filePath));
                    
            //         // Store the image filename in the restaurant model
            //         $banner->image = basename($filePath);
            //         // If the image dimensions or weight do not meet the requirements, store the original image path
            //     }
            // }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/banner/');
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

            return redirect()->route('media-advertising.index')->with(['success' => 'Banner added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('media-advertising.index')->with(['failed' => 'Banner added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Media Advertising';
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

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $filename = time().'.'.$image->getClientOriginalExtension();
            //     $filePath = 'assets/images/banner/'.$filename;
                
            //     // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
            //     if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
            //         // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
            //         return redirect()->route('media-advertising.index')->with(['failed' => 'Image Size 200 x 200!']);

            //     } else {
            //         // Resize the image
            //         $img = Image::make($image)->resize(200, 200);
                    
            //         // Save the resized image
            //         $img->save(public_path($filePath));
                    
            //         // Store the image filename in the restaurant model
            //         $banner->image = basename($filePath);
            //         // If the image dimensions or weight do not meet the requirements, store the original image path
            //     }
            // }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/banner/');
                $image->move($destinationPath, $name);
                $banner->image = $name;
            }

            $banner->save();

            return redirect()->route('media-advertising.index')->with(['success' => 'Banner edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('media-advertising.index')->with(['failed' => 'Banner edited Failed! '. $th->getMessage()]);
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
