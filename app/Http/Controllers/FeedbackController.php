<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        $data['page_title'] = 'Feedback';
        $data['orders'] = Order::orderby('id', 'desc')->get();

        return view('master-data.feedback.index', $data);
    }
}
