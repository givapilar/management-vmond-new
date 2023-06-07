<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;
use Intervention\Image\Facades\Image;

class MeetingRoomController extends Controller
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
        $data['page_title'] = 'Meeting Room';
        $data['meeting_rooms'] = MeetingRoom::orderby('id', 'asc')->get();

        return view('management-toko-online.meeting-room.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Meja Meeting';
        $data['meeting_room'] = MeetingRoom::get();

        return view('management-toko-online..meeting-room.create',$data);
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

            $meeting_room = new MeetingRoom();
            $meeting_room->nama = $validateData['nama'];
            $meeting_room->slug = $slug;
            $meeting_room->no_meja = $validateData['no_meja'];
            $meeting_room->harga = $replaceComma ;
            $meeting_room->status = $validateData['status'];
            $meeting_room->description = $validateData['description'];

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $name = time() . '.' . $image->getClientOriginalExtension();
            //     $destinationPath = public_path('assets/images/meeting-room/');
            //     $image->move($destinationPath, $name);
            //     $meeting_room->image = $name;
            // }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/meeting-room/'.$filename;
                
                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
                    return redirect()->route('meeting-room.index')->with(['failed' => 'Image Size 200 x 200!']);

                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);
                    
                    // Save the resized image
                    $img->save(public_path($filePath));
                    
                    // Store the image filename in the restaurant model
                    $meeting_room->image = basename($filePath);
                    // If the image dimensions or weight do not meet the requirements, store the original image path
                }
            }

            $meeting_room->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Meeting Room'.$meeting_room->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('meeting-room.index')->with(['success' => 'Meeting Room added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('meeting-room.index')->with(['failed' => 'Meeting Room added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Meja Meeting';
        $data['meeting_room'] = MeetingRoom::find($id);

        return view('management-toko-online.meeting-room.edit',$data);
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
            // dd($replaceComma);

            $meeting_room = MeetingRoom::findOrFail($id);
            $meeting_room->nama = $validateData['nama'];
            $meeting_room->slug = $slug;
            $meeting_room->no_meja = $validateData['no_meja'];
            $meeting_room->harga = $replaceComma;
            $meeting_room->status = $validateData['status'];
            $meeting_room->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'assets/images/meeting-room/'.$filename;
                
                // Check if the image width is greater than 200 and the weight is less than 2MB (adjust the limit as per your requirement)
                if (Image::make($image)->width() > 200 && $image->getSize() < 2000000) {
                    // $restaurant->image = $image->storeAs('assets/images/restaurant', $filename);
                    return redirect()->route('meeting-room.index')->with(['failed' => 'Image Size 200 x 200!']);

                } else {
                    // Resize the image
                    $img = Image::make($image)->resize(200, 200);
                    
                    // Save the resized image
                    $img->save(public_path($filePath));
                    
                    // Store the image filename in the restaurant model
                    $meeting_room->image = basename($filePath);
                    // If the image dimensions or weight do not meet the requirements, store the original image path
                }
            }

            $meeting_room->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Meeting Room'.$meeting_room->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('meeting-room.index')->with(['success' => 'Meeting Room edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('meeting-room.index')->with(['failed' => 'Meeting Room edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $meeting_room = MeetingRoom::findOrFail($id);
            $meeting_room->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Meeting Room '.$meeting_room->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Meeting Room deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
