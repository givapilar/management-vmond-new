<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\MejaRestaurants;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;

class MejaRestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:meja-restaurant-list', ['only' => 'index']);
        $this->middleware('permission:meja-restaurant-create', ['only' => ['create','store']]);
        $this->middleware('permission:meja-restaurant-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:meja-restaurant-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Meja Restaurant';
        $data['meja_restaurants'] = MejaRestaurants::orderby('id', 'asc')->get();

        return view('master-data.meja-restaurant.index', $data);
    }

    public function qrDownload()
{
    $meja_restaurants = MejaRestaurants::get();

    foreach ($meja_restaurants as $meja_restaurant) {
        $barcodeData = DNS2D::getBarcodePNG($meja_restaurant->barcode, 'QRCODE');

        // Create a new image resource from the barcode data
        $barcodeImage = imagecreatefromstring($barcodeData);

        // Create a new image with a white background
        $imageWidth = imagesx($barcodeImage);
        $imageHeight = imagesy($barcodeImage);
        $imageWithBackground = imagecreatetruecolor($imageWidth, $imageHeight);
        $whiteColor = imagecolorallocate($imageWithBackground, 255, 255, 255);
        imagefill($imageWithBackground, 0, 0, $whiteColor);

        // Copy the barcode image onto the image with the white background
        imagecopy($imageWithBackground, $barcodeImage, 0, 0, 0, 0, $imageWidth, $imageHeight);

        // Save the image with the white background to a file (e.g., barcode_with_background.jpg)
        $imageName = 'barcode_with_background.jpg'; // Change the file extension to .jpg if needed
        $filePath = public_path('storage/' . $imageName);
        imagejpeg($imageWithBackground, $filePath);

        // Send the file as a download response and delete it afterward
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
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

            $barcode = 'https://managementvmond.controlindo.com/';
            $meja_restaurant = new MejaRestaurants();
            $meja_restaurant->nama = $validateData['nama'];
            $meja_restaurant->category = $validateData['category'];
            $meja_restaurant->status = $validateData['status'];
            $meja_restaurant->description = $validateData['description'];
            $meja_restaurant->barcode = $barcode;

            
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
            'no_meja' => 'required',
            'description' => 'nullable',
        ]);

        try {

            $barcode = 'http://vmondcafe.test/login?jenis_meja=restaurant&no_meja='.$request->no_meja;
            $meja_restaurant = MejaRestaurants::findOrFail($id);
            
            $meja_restaurant->nama = $validateData['nama'];
            $meja_restaurant->status = $validateData['status'];
            $meja_restaurant->category = $validateData['category'];
            $meja_restaurant->no_meja = $validateData['no_meja'];
            $meja_restaurant->barcode = $barcode;
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
