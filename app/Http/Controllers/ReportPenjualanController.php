<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Http\Request;

class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Stok Masuk';
        $data['orders'] = Order::orderby('id', 'asc')->get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('order_id') ? $request->order_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = Order::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = Order::whereDate('created_at', $request->start_date)->when($request->order_id, function($q) use($request){{
                    return $q->get();
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = Order::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->order_id, function($q) use($request){{
                return $q->get();
            }})->get();
            // dd($stok);
        } elseif ($type == 'yearly'){
            $stok = Order::whereYear('created_at', $request->year)->when($request->order_id, function($q) use($request){{
                return $q->get();
            }})->get();
        }
   
        $data['orders'] = $stok;


        return view('report.penjualan', $data);
    }

    public function show($id)
    {
        $data['page_title'] = 'Report Show';
        $data['orders'] = Order::findorFail($id);
        // dd($data['orders'])->orderPivot->name;

        $data['order_pivots'] = OrderPivot::get();
        return view('report.show',$data);
    }
}
