<?php

namespace App\Http\Controllers;

use App\Models\OtherSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OtherSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Other Settings';

        $other_settings = OtherSettings::orderBy('id', 'ASC')->get()->first();

        if (!$other_settings) {
            $data['other_setting'] = [];
        }

        $data['other_setting'] = $other_settings;

        return view('master-data.other.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);

        if ($id == '0') {
           $other = new OtherSettings();
        } else {
            $other = OtherSettings::findorFail($id);
        }

        $validate = $request->validate([
            'no_wa' => 'required|regex:/[0-9]/|min:11|max:13',
            'pb01' => 'required|regex:/[0-9]/',
            'layanan' => 'required|regex:/[0-9]/',
            // 'time_billiard' => 'nullable',
            'time_start' => 'required',
            'time_close' => 'required',
            'time_start_weekend' => 'required',
            'time_close_weekend' => 'required',
        ]);

        $other->no_wa = $validate['no_wa'];
        $other->pb01 = $validate['pb01'];
        $other->layanan = $validate['layanan'];
        // $other->time_billiard = $validate['time_billiard'];
        $other->time_start = $validate['time_start'];
        $other->time_close = $validate['time_close'];
        $other->time_start_weekend = $validate['time_start_weekend'];
        $other->time_close_weekend = $validate['time_close_weekend'];
        $other->save();

        return redirect()->route('other.index')->with(['success' => 'Data inserted or updated successfully!']);
    }
}
