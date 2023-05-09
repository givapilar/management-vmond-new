<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;

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
            $meeting_room = new MeetingRoom();
            $meeting_room->nama = $validateData['nama'];
            $meeting_room->nama = $slug;
            $meeting_room->no_meja = $validateData['no_meja'];
            $meeting_room->harga = $validateData['harga'];
            $meeting_room->status = $validateData['status'];
            $meeting_room->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/meeting-room/');
                $image->move($destinationPath, $name);
                $meeting_room->image = $name;
            }

            $meeting_room->save();

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
            $meeting_room = MeetingRoom::findOrFail($id);
            $meeting_room->nama = $validateData['nama'];
            $meeting_room->nama = $slug;
            $meeting_room->no_meja = $validateData['no_meja'];
            $meeting_room->harga = $validateData['harga'];
            $meeting_room->status = $validateData['status'];
            $meeting_room->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/meeting_room/');
                $image->move($destinationPath, $name);
                $meeting_room->image = $name;
            }

            $meeting_room->save();

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
        });

        Session::flash('success', 'Meeting Room deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
