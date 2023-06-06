<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\materialImport;


class ImportExcelController extends Controller
{
    public function import(Request $request)
    {
        
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new materialImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Material Success!']);
            } catch (\Throwable $th) {
                // dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        } 

    }
}
