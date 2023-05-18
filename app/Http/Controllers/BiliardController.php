<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use File;


class BiliardController extends Controller
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
        $data['page_title'] = 'Biliard';
        $data['biliards'] = Biliard::orderby('id', 'asc')->get();

        return view('management-toko-online.biliard.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Meja Biliard';
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
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/biliard/');
                $image->move($destinationPath, $name);
                $biliard->image = $name;
            }

            $biliard->save();

            return redirect()->route('biliard.index')->with(['success' => 'Biliard added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('biliard.index')->with(['failed' => 'Biliard added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Meja Biliard';
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
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/biliard/');
                $image->move($destinationPath, $name);
                $biliard->image = $name;
            }

            $biliard->save();

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
        });

        Session::flash('success', 'Biliard deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
