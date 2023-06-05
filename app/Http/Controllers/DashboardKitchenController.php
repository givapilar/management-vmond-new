<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Http\Request;

class DashboardKitchenController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';  
        $data['orders'] = OrderPivot::get();
        // $data['orders'] = OrderPivot::get();

        // dd($data['orders']->orderPivot);

        return view('process.kitchen.dashboard',$data);
    }

    public function detail($id)
    {
        $data['orders'] = Order::findorFail($id);
        $data['orders_pivots'] = OrderPivot::get();

        return view('process.kitchen.index',$data);
    }

}
