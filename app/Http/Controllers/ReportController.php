<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Stok Masuk';
        $data['order'] = Order::orderby('id', 'asc')->get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = OrderPivot::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = OrderPivot::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = OrderPivot::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = OrderPivot::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }
   
        $data['order_pivots'] = $stok;

        return view('report.penjualan', $data);
    }
}
