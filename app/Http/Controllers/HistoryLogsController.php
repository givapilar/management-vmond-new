<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Illuminate\Http\Request;

class HistoryLogsController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'History Log';
        $data['breadcumb'] = 'History Log';
        $data['logs'] = HistoryLog::latest()->get();
        return view('history-log.index', $data);
    }
}
