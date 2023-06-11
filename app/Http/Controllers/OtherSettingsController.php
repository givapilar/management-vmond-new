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
            'no_wa' => 'required|regex:/[0-9]/|min:11|max:13'
        ]);

        $other->no_wa = $validate['no_wa'];
        $other->save();

        return redirect()->route('other.index')->with(['success' => 'Data inserted or updated successfully!']);
    }
}
