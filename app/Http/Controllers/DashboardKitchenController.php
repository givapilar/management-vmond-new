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
        $data['order_table'] = Order::get();
            // $orderTable = OrderPivot::get();
            // dd($orderPivot);
            // View::share('order_table',$orderTable);

        // dd($data['orders']->orderPivot);

        return view('process.kitchen.dashboard',$data);
    }

    public function detail($id)
    {
        $data['orders'] = Order::findorFail($id);
        $data['orders_pivots'] = OrderPivot::get();

        return view('process.kitchen.index',$data);
    }

    public function statusDashboard(Request $request)
    {
        try {
            $order = OrderPivot::where('id', $request->id)->first();
            
            $order->status_pemesanan = 'Selesai';
            $order->save();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
   
    public function statusDashboardAll(Request $request)
    {
        try {
            $order = OrderPivot::where('order_id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

}
