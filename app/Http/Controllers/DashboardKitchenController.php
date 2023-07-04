<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderBilliard;
use App\Models\OrderMeeting;
use App\Models\OrderPivot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardKitchenController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';  
        // $data['orders'] = OrderPivot::get();
        // $data['order_table'] = Order::get();
        
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');
        // $data['orders'] = Order::get();
        $orders = Order::where('status_pembayaran', 'Paid')->where('status_pemesanan', null)->get();
        $data['orders'] = $orders;
        // dd($orders[0]->orderPivotMakanan());
        // $data['order_billiards'] = $order->orderBilliardMakananTime($current_time);
        // $data['order_meetings'] = $order->orderMeetingMakananTime($current_time);
        // $data['order_billiards'] = OrderBilliard::get();
        

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
            $orderPivot = OrderPivot::where('order_id', $orderMaster->id)->where('category', 'Makanan')->get()->count();
            $orderPivotDone = OrderPivot::where('order_id', $orderMaster->id)->where('category', 'Makanan')->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderPivot == $orderPivotDone) {
                $statusPivot = true;
            }
            // Count OrderMeeting
            $orderMeeting = OrderMeeting::where('order_id', $orderMaster->id)->where('category', 'Makanan')->get()->count();
            $orderMeetingDone = OrderMeeting::where('order_id', $orderMaster->id)->where('category', 'Makanan')->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderMeeting == $orderMeetingDone) {
                $statusMeeting = true;
            }
            // Count OrderBilliard
            $orderBilliard = OrderBilliard::where('order_id', $orderMaster->id)->where('category', 'Makanan')->get()->count();
            $orderBilliardDone = OrderBilliard::where('order_id', $orderMaster->id)->where('category', 'Makanan')->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderBilliard == $orderBilliardDone) {
                $statusBilliard = true;
            }

            if ($statusPivot && $statusMeeting && $statusBilliard) {
                $orderMaster->status_pemesanan = 'Done';
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
            $orderMaster->status_pemesanan = null;
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

}
