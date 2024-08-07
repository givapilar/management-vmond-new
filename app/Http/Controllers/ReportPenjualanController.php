<?php

namespace App\Http\Controllers;

use App\Models\AccountUser;
use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Http\Request;

class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Report Penjualan';
        // $data['orders'] = Order::orderby('id', 'asc')->get();

        $data['account_users'] = AccountUser::get();
        // $type = $request->has('type') ? $request->type : 'day';
        // $user = $request->has('order_id') ? $request->order_id : 'All';
        // if ($type == 'day') {
        //     if ($user == 'All') {
        //         $stok = Order::whereDate('created_at', date('Y-m-d'))->get();
        //         // dd($stok);
        //     }else{
        //         $stok = Order::whereDate('created_at', $request->start_date)->when($request->order_id, function($q) use($request){{
        //             return $q->get();
        //          }})->get();
        //     }
        // } elseif ($type == 'monthly') {
        //     $stok = Order::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->order_id, function($q) use($request){{
        //         return $q->get();
        //     }})->get();
        //     // dd($stok);
        // } elseif ($type == 'yearly'){
        //     $stok = Order::whereYear('created_at', $request->year)->when($request->order_id, function($q) use($request){{
        //         return $q->get();
        //     }})->get();
        // }
   
        // $data['orders'] = $stok;

        $type = $request->has('type') ? $request->type : 'day';
        $user = $request->has('user_id') ? $request->user_id : 'All';
        if ($type == 'day') {
            // dd('masuk1');
            $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            if ($user == 'All') {
                $stok = Order::whereDate('created_at', $date)
                            ->where('status_pembayaran', 'Paid')
                            ->orderBy('id', 'asc')
                            ->get();
                // $orderDetail = OrderPivot::whereDate('created_at', $date)
                // ->whereHas('order', function ($query) {
                //     $query->where('status_pembayaran', 'Paid');
                // })->get();
            } else {
                // dd('masuk2');
                $stok = Order::whereDate('created_at', $date)
                            ->where('user_id', $request->user_id)
                            ->where('status_pembayaran', 'Paid')
                            ->orderBy('id', 'asc')
                            ->get();
                // $orderDetail = OrderPivot::whereHas('order', function ($query) {
                //     $query->where('status_pembayaran', 'Paid');
                // })->get();
                
            }
        } elseif ($type == 'monthly') {
            $month = $request->has('month') ? date('m', strtotime($request->month)) : date('m');
            $stok = Order::whereMonth('created_at', $month)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->where('status_pembayaran', 'Paid')
                        ->orderBy('id', 'asc')
                        ->get();

            // $orderDetail = OrderPivot::whereHas('order', function ($query) {
            //     $query->where('status_pembayaran', 'Paid');
            // })->get();
        } elseif ($type == 'yearly') {
            $year = $request->has('year') ? $request->year : date('Y');
            $stok = Order::whereYear('created_at', $year)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->where('status_pembayaran', 'Paid')
                        ->orderBy('id', 'asc')
                        ->get();
            // $orderDetail = OrderPivot::whereHas('order', function ($query) {
            //     $query->where('status_pembayaran', 'Paid');
            // })->get();
        }

        $totalPriceSum = $stok->sum('total_price');
        $pb01 = $stok->sum('pb01');
        $service = $stok->sum('service');
        $packing = $stok->sum('packing');


        $harga_diskon = 0;
        $qty = 0;
        $hasil = 0;
        // foreach ($orderDetail as $key => $value) {
        //     $harga_diskon = $value->harga_diskon;
        //     $qty = $value->qty; 
        //     $hasil += $harga_diskon * $qty;
        // }
        // dd(number_format($hasil,0));


        $data['total_price'] = $totalPriceSum;
        $data['pb01'] = $pb01;
        $data['service'] = $service;
        $data['packing'] = $packing;
        // $data['total_diskon'] = $hasil;
        $data['total_qty'] = $qty;
        $data['harga_diskon'] = $harga_diskon;
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
