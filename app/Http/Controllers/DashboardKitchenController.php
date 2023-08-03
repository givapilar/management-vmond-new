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
        // dd($order_time);

        $data['page_title'] = 'Dashboard';  
        // $data['orders'] = OrderPivot::get();
        // $data['order_table'] = Order::get();
        
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');
        // $data['orders'] = Order::get();
        $today = Carbon::today();
        $orders = Order::where('status_pembayaran', 'Paid')->whereDate('created_at', $today)->orderBy('id', 'DESC')->where('status_pesanan', 'process')->get();
        $data['orders'] = $orders;

        // dd($orders[0]->orderPivotMakanan());
        // $data['order_billiards'] = $order->orderBilliardMakananTime($current_time);
        // $data['order_meetings'] = $order->orderMeetingMakananTime($current_time);
        // $data['order_billiards'] = OrderBilliard::get();
          
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

    public function history(Request $request){
        $data['page_title'] = 'Dashboard Waiters';
        $data['order_pivots'] = OrderPivot::orderBy('id', 'ASC')->get();
        // $today = Carbon::today();
        $query = Order::query();

        // Cek apakah ada input tanggal mulai (start_date) dari form
        if ($request->has('start_date')) {
            $startDate = $request->input('start_date');
            $query->whereDate('created_at', '>=', $startDate);
        } else {
            // Jika tidak ada input tanggal, filter default menjadi "hari ini"
            $query->whereDate('created_at', Carbon::today());
        }

        // / Tambahkan kondisi untuk status pembayaran "Paid" dan status pesanan "process"
        $query->where('status_pembayaran', 'Paid')->where('status_pesanan', 'process');

        $query->orderByDesc('created_at');
        $orders = $query->get();
        
        // $time = Order::where('status_pembayaran', 'Paid')->orderBy('id', 'DESC')->where('status_pesanan', 'process')->get();
        $data['orders'] = $orders;
        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }
        return view('process.history.kitchen-history',$data);
    }
}
