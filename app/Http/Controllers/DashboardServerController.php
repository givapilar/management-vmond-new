<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\OtherSettings;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardServerController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard Kasir';
        $data['order_pivots'] = OrderPivot::orderBy('updated_at', 'ASC')->get();

        $query = Order::query();

        // Set start_date dan time_from ke 1 jam yang lalu
        $oneHourAgo = Carbon::now()->subHour();
        $query->where('created_at', '>=', $oneHourAgo);

        $query->where('status_pembayaran', 'Paid')->where('status_pesanan', 'process');
        $query->orderByDesc('invoice_no');
        $getNameCustomer = $query->pluck('name')->unique();

        // Get By Nama Customer
        if ($request->has('nama_customer')) {
            $namaCustomer = $request->input('nama_customer');
            if ($namaCustomer != 'All') {
                $query->where('name', $namaCustomer);
            }
        }

        $orders = $query->get();

        $data['orders'] = $orders;
        $data['nama_customers'] = $getNameCustomer;

        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }

        return view('process.server.dashboard', $data);

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

        return view('process.server.index',$data);
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

    public function show($id)
    {
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');

        $orders = Order::findOrFail($id);
        // $data['order_pivott'] = OrderPivot::sum()
        $data['other_setting'] = OtherSettings::get()->first();
    
        if ($orders->status_pembayaran !== 'Paid' || $orders->status_pesanan == null) {
            abort(404);
        }
    
        $data['orders'] = $orders;
       	// $pdf = PDF::loadview('process.kitchen.pdf',$data);
        return PDF::loadview('process.server.pdf', $data)->stream('order-' . $orders->id . '.pdf');
    	// return $pdf->download('order-'.$orders->id.'.pdf');
    }
}
