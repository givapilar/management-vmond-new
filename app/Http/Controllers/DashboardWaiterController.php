<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardWaiterController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard Waiters';
        $data['order_pivots'] = OrderPivot::orderBy('id', 'ASC')->get();
        // $data['orders'] = OrderPivot::get();
        // $data['order_table'] = Order::orderBy('id', 'ASC')->get();
        $today = Carbon::today();
        $orders = Order::where('status_pembayaran', 'Paid')->whereDate('created_at', $today)->orderBy('id', 'DESC')->get();
        $data['orders'] = $orders;
            // $orderTable = OrderPivot::get();
            // dd($orderPivot);
            // View::share('order_table',$orderTable);

        // dd($data['orders']->orderPivot);

        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }
        return view('process.waiters.dashboard',$data);
    }

    public function calculateElapsedTime($createdAt)
    {
        $now = Carbon::now();
        $created = Carbon::parse($createdAt);
        $elapsedTime = $created->diffForHumans($now);

        return $elapsedTime;
    }

    public function detail($id)
    {
        $data['orders'] = Order::findorFail($id);
        $data['orders_pivots'] = OrderPivot::orderBy('id', 'ASC')->get();

        return view('process.waiters.index',$data);
    }

    public function statusDashboard(Request $request)
    {
        try {
            $order = OrderPivot::where('id', $request->id)->first();
            if ($request->value == true) {
                $order->status_pemesanan = 'Selesai';
            }else{
                $order->status_pemesanan = 'Belum Selesai';
            }
            $order->update();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function statusDashboardAll(Request $request)
    {
        try {
            // $order = Order::find($request->orderId);
            // $order->status_pemesanan = 'Selesai';
            // $order->save();
            // $order = Order::where('id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            $order = OrderPivot::where('order_id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function statusUpdate(Request $request)
    {
        try {
            // $order = Order::find($request->get('id'));
            // $order->status_pemesanan = 'Clear';
            // $order->save();
            Order::where('id', $request->id)->update(['status_pesanan' => 'selesai']);
            return response()->json(['success' => true, 'message' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['failed' => false, 'message' => $th->getMessage()]);
        }
    }
    public function tes(Request $request,$id)
    {
        try {
            $order = Order::find($request->id);
            $order->status_pemesanan = 'Selesai';
            $order->save();
            // $order = Order::where('id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['failed' => false, 'message' => $th->getMessage()]);
        }
    }
}
