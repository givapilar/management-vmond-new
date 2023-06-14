<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;
use Intervention\Image\Facades\Image;



class BiliardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:departement-list', ['only' => 'index']);
        $this->middleware('permission:departement-create', ['only' => ['create','store']]);
        $this->middleware('permission:departement-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:departement-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Sport';
        $data['biliards'] = Biliard::orderby('id', 'asc')->get();

        return view('management-toko-online.biliard.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Meja Sport';
        $data['biliard'] = Biliard::get();

        return view('management-toko-online.biliard.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'no_meja' => 'required',
            'harga' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $replaceTitik = str_replace('.', '',$request->harga);
            $replaceComma = substr($replaceTitik, 0 , -3);

            $biliard = new Biliard();
            $biliard->nama = $validateData['nama'];
            $biliard->slug = $slug;
            $biliard->no_meja = $validateData['no_meja'];
            $biliard->harga = $replaceComma;
            $biliard->status = $validateData['status'];
            $biliard->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/biliard/'.$filename;

                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
                    return redirect()->route('biliard.index')->with(['failed' => 'Image Size 200 x 200!']);

                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);

                    // Save the resized image
                    $img->save(public_path($filePath));

                    // Store the image filename in the restaurant model
                    $biliard->image = basename($filePath);
                    // If the image dimensions or weight do not meet the requirements, store the original image path
                }
            }

            $biliard->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Biliard '.$biliard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('biliard.index')->with(['success' => 'Biliard added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('biliard.index')->with(['failed' => 'Biliard added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Meja Sport';
        $data['biliard'] = Biliard::find($id);

        return view('management-toko-online.biliard.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'no_meja' => 'required',
            'harga' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

        try {
            $slug = str_replace(' ','&',strtolower($validateData['nama']));
            $replaceTitik = str_replace('.', '',$request->harga);
            $replaceComma = substr($replaceTitik, 0 , -3);

            $biliard = Biliard::findOrFail($id);
            $biliard->nama = $validateData['nama'];
            $biliard->slug = $slug;
            $biliard->no_meja = $validateData['no_meja'];
            $biliard->harga = $replaceComma;
            $biliard->status = $validateData['status'];
            $biliard->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/biliard/'.$filename;

                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
                    return redirect()->route('biliard.index')->with(['failed' => 'Image Size 200 x 200!']);

                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);

                    // Save the resized image
                    $img->save(public_path($filePath));

                    // Store the image filename in the restaurant model
                    $biliard->image = basename($filePath);
                    // If the image dimensions or weight do not meet the requirements, store the original image path
                }
            }

            $biliard->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Delete Biliard '.$biliard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('biliard.index')->with(['success' => 'Biliard edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('biliard.index')->with(['failed' => 'Biliard edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $Biliard = Biliard::findOrFail($id);
            $Biliard->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Biliard '.$Biliard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Biliard deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
