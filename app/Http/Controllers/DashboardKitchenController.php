<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderBilliard;
use App\Models\OrderMeeting;
use App\Models\OrderPivot;
use App\Models\OtherSettings;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;

class DashboardKitchenController extends Controller
{
    public function index(Request $request)
    {

        $data['page_title'] = 'Dashboard';  
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');
        $today = Carbon::today();
        $fourHoursAgo = Carbon::now()->subHours(4);
        $orders = Order::where('status_pembayaran', 'Paid')->whereDate('created_at', $fourHoursAgo)->orderBy('id', 'DESC')->where('status_pesanan', 'process')->get();
        $data['orders'] = $orders;

        // Calculate elapsed time for each order
        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }

        return view('process.kitchen.dashboard',$data);
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
        $data['orders_pivots'] = OrderPivot::get();

        return view('process.kitchen.index',$data);
    }
    

    public function statusDashboard(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = $request->type;
            if ($type == 'pivot') {
                $order = OrderPivot::where('id', $request->id)->first();
                
                $order->status_pemesanan = 'Selesai';
                $order->save();
            }elseif ($type == 'meeting') {
                $order = OrderMeeting::where('id', $request->id)->first();
                
                $order->status_pemesanan = 'Selesai';
                $order->save();
            }elseif ($type == 'billiard') {
                $order = OrderBilliard::where('id', $request->id)->first();
                
                $order->status_pemesanan = 'Selesai';
                $order->save();
            }

            // Status Order
            $statusPivot = false;
            $statusMeeting = false;
            $statusBilliard = false;
            // Check All Order
            $orderMaster = Order::where('id', $order->order_id)->first();
            // Count OrderPivot
            $orderPivot = OrderPivot::where('order_id', $orderMaster->id)->get()->count();
            $orderPivotDone = OrderPivot::where('order_id', $orderMaster->id)->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderPivot == $orderPivotDone) {
                $statusPivot = true;
            }
            // Count OrderMeeting
            $orderMeeting = OrderMeeting::where('order_id', $orderMaster->id)->get()->count();
            $orderMeetingDone = OrderMeeting::where('order_id', $orderMaster->id)->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderMeeting == $orderMeetingDone) {
                $statusMeeting = true;
            }
            // Count OrderBilliard
            $orderBilliard = OrderBilliard::where('order_id', $orderMaster->id)->get()->count();
            $orderBilliardDone = OrderBilliard::where('order_id', $orderMaster->id)->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderBilliard == $orderBilliardDone) {
                $statusBilliard = true;
            }

            if ($statusPivot && $statusMeeting && $statusBilliard) {
                $orderMaster->status_pesanan = 'Done';
                $orderMaster->save();
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function statusRemove(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = $request->type;
            if ($type == 'pivot') {
                $order = OrderPivot::where('id', $request->id)->first();
                
                $order->status_pemesanan = null;
                $order->save();
            }elseif ($type == 'meeting') {
                $order = OrderMeeting::where('id', $request->id)->first();
                
                $order->status_pemesanan = null;
                $order->save();
            }elseif ($type == 'billiard') {
                $order = OrderBilliard::where('id', $request->id)->first();
                
                $order->status_pemesanan = null;
                $order->save();
            }
            // Check All Order
            $orderMaster = Order::where('id', $order->order_id)->first();
            $orderMaster->status_pesanan = 'process';
            $orderMaster->save();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
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

    public function show($id)
    {
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');

        $orders = Order::findOrFail($id);
        $data['other_setting'] = OtherSettings::get()->first();
    
        if ($orders->status_pembayaran !== 'Paid' || $orders->status_pesanan == null) {
            abort(404); // or handle the case when the order does not meet the desired conditions
        }
    
        $data['orders'] = $orders;
       	$pdf = PDF::loadview('process.kitchen.pdf',$data);
        return PDF::loadview('process.kitchen.pdf', $data)->stream('order-' . $orders->id . '.pdf');
    	// return $pdf->download('order-'.$orders->id.'.pdf');
    }

    public function history(Request $request) {
        $data['page_title'] = 'Dashboard History';
        // $data['order_pivots'] = OrderPivot::orderBy('id', 'ASC')->get();
        // $pv = OrderPivot::get();

        // $pv = OrderPivot::query()
        //     ->join('restaurants', 'restaurants.id', '=', 'order_pivots.restaurant_id')
        //     ->join('restaurant_pivots', 'restaurant_pivots.restaurant_id', '=', 'restaurants.id')
        //     ->join('tags', 'tags.id', '=', 'restaurant_pivots.tag_id')
        //     ->orderBy('tags.position', 'desc')
        //     ->get();
        
        // $data['order_pivots'] = $pv;
    




        $query = Order::query();
        $oneHourAgo = Carbon::now()->subHour();
        $query->where('status_pembayaran', 'Paid')->where('status_pesanan', 'process');
        $getNameCustomer = $query->whereDate('created_at', Carbon::today())->get()->pluck('name')->unique();
        $getNoInvoice = $query->whereDate('created_at', Carbon::today())->orderByDesc('invoice_no')->get()->pluck('invoice_no')->unique();
        // if ($request->has('start_date')) {
        //     $startDate = $request->input('start_date');

        //     if ($request->has('time_from')) {
        //         $timeFrom = $request->input('time_from');
        //         $startDateAndTimeFrom = Carbon::parse($startDate . ' ' . $timeFrom);
        //         $query->where('created_at', $startDateAndTimeFrom);
        //     } else {
        //         $query->whereDate('created_at', $startDate);
        //     }

        //     if ($request->has('time_to')) {
        //         $timeTo = $request->input('time_to');
        //         $startDateAndTimeTo = Carbon::parse($startDate . ' ' . $timeTo);
        //         $query->where('created_at', '<=', $startDateAndTimeTo);
        //     } else {
        //         $query->whereDate('created_at', '<', Carbon::parse($startDate)->addDay());
        //     }
            
        // } else {
        //     // $query->whereDate('created_at', Carbon::today());
        //     $query->where('created_at', '>=', $oneHourAgo);
        // }

        
        if ($request->has('start_date')) {
            $start_date = $request->input('start_date');
            $time_from = $request->input('time_from');
            $time_to = $request->input('time_to');
            
            // Query untuk mengambil data dari tabel order dengan filter
            $ordersQuery = Order::query();

            if ($start_date) {
                $ordersQuery->whereDate('created_at', $start_date);
            }
            
            if ($time_from) {
                $ordersQuery->whereTime('created_at', '>=', $time_from);
            }

            if ($time_to) {
                $ordersQuery->whereTime('created_at', '<=', $time_to);
            }

            $orders = $ordersQuery
                ->where('status_pembayaran', 'Paid')
                ->where('status_pesanan', 'process')
                ->orderByDesc('invoice_no')
                ->get();
            
        } else {
            // $query->whereDate('created_at', Carbon::today());
            // $query->where('created_at', '>=', $oneHourAgo);
            $oneHourAgo = Carbon::now()->subHour(1);
        
            $orders = Order::where('created_at', '>=', $oneHourAgo)
                ->where('status_pembayaran', 'Paid')
                ->where('status_pesanan', 'process')
                ->orderByDesc('invoice_no')
                ->get();

                
        }

        
        
        // $query->orderByDesc('created_at');

        // Get By Nama Customer
        if ($request->has('nama_customer')) {
            $namaCustomer = $request->input('nama_customer');
            if ($namaCustomer != 'All') {
                $query->where('name', $namaCustomer);
            }
        }

        // Get BY NO Invoice
        if ($request->has('no_invoice')) {
            $noInvoice = $request->input('no_invoice');
            $query->where('invoice_no', $noInvoice);
        }

        // $orders = $query->get();

        $data['orders'] = $orders;
        $data['nama_customers'] = $getNameCustomer;
        $data['no_invoices'] = $getNoInvoice;
        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }

        return view('process.history.kitchen-history', $data);

    }
    
}
