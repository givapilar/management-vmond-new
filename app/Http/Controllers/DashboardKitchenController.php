<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderBilliard;
use App\Models\OrderPivot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardKitchenController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';  
        $data['orders'] = OrderPivot::get();
        // $data['order_table'] = Order::get();
        $data['order_table'] = Order::whereDate('created_at', Carbon::today())->get();
        // dd($data['order_table']);
        $data['order_billiards'] = OrderBilliard::get();

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
