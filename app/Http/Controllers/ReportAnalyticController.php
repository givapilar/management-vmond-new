<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderBilliard;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAnalyticController extends Controller
{
    public function index(Request $request)
    {
        $data['restaurants'] = Restaurant::orderBy('id', 'asc')->get();
        $order = Order::orderBy('id', 'asc')->where('status_pembayaran','Paid')->get();
        $orderDetails = OrderPivot::orderBy('id', 'asc')->get();
        
        $type = $request->has('type') ? $request->type : 'day';
        $resto = $request->has('restaurant_id') ? $request->restaurant_id : 'All';
        $category = $request->has('category') ? $request->category : null;
        // dd($category);
        // if ($type == 'day') {
        //     $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
        //     if ($resto == 'All') {
        //         $orderDetails = OrderPivot::whereDate('created_at', $date)
        //                         ->whereHas('order', function ($query) {
        //                             $query->where('status_pembayaran', 'Paid');
        //                         })
        //                         ->when($category, function ($query) use ($category) {
        //                             return $query->where('category', $category);
        //                         })
        //                         ->orderBy('id', 'asc')
        //                         ->get();

        //         $orderTotal = Order::whereDate('created_at', $date)
        //                         ->where('status_pembayaran', 'Paid')
        //                         ->orderBy('id', 'asc')
        //                         ->get()->sum('total_price');

        //         $totalBartender = OrderPivot::whereDate('created_at', $date)
        //                     ->where('category', 'Minuman')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //         $totalKitchen = OrderPivot::whereDate('created_at', $date)
        //                     ->where('category', 'Makanan')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //         $totalFwb = Order::whereDate('created_at', $date)
        //                     ->whereNotNull('biliard_id')
        //                     ->sum('total_price');

        //         $groupedItems = $orderDetails->groupBy(function ($item) {
        //             return $item->restaurant->nama . '|' . $item->category;
        //         });

        //         $topDishes = OrderPivot::selectRaw('restaurant_id, SUM(qty) as total_qty')
        //                     ->whereDate('created_at', $date)
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->groupBy('restaurant_id')
        //                     ->orderByDesc('total_qty')
        //                     ->limit(10)
        //                     ->get();


        //     } else {
        //         $orderDetails = OrderPivot::whereDate('created_at', $date)
        //                     ->where('restaurant_id', $request->restaurant_id)
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->orderBy('id', 'asc')
        //                     ->get();

        //         $totalBartender = OrderPivot::whereDate('created_at', $date)
        //                     ->where('category', 'Minuman')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //         $totalKitchen = OrderPivot::whereDate('created_at', $date)
        //                     ->where('category', 'Makanan')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //         $totalFwb = Order::whereDate('created_at', $date)
        //                     ->whereNotNull('biliard_id')
        //                     ->sum('total_price');

        //         $topDishes = OrderPivot::selectRaw('restaurant_id, SUM(qty) as total_qty')
        //                     ->whereDate('created_at', $date)
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->groupBy('restaurant_id')
        //                     ->orderByDesc('total_qty')
        //                     ->limit(10)
        //                     ->get();
        //         }
        // } elseif ($type == 'monthly') {
        //     $month = $request->has('month') ? date('m', strtotime($request->month)) : date('m');
        //     $orderDetails = OrderPivot::whereMonth('created_at', $month)
        //                 ->whereHas('order', function ($query) {
        //                     $query->where('status_pembayaran', 'Paid');
        //                 })
        //                 ->orderBy('id', 'asc')
        //                 ->get();
                    
        //     $orderTotal = Order::whereMonth('created_at', $month)
        //                 ->where('status_pembayaran', 'Paid')
        //                 ->orderBy('id', 'asc')
        //                 ->get()->sum('total_price');

        //     $totalBartender = OrderPivot::whereMonth('created_at', $month)
        //                     ->where('category', 'Minuman')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //     $totalKitchen = OrderPivot::whereMonth('created_at', $month)
        //                     ->where('category', 'Makanan')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //     $totalFwb = Order::whereMonth('created_at', $month)
        //                     ->whereNotNull('biliard_id')
        //                     ->sum('total_price');

        //     $groupedItems = $orderDetails->groupBy(function ($item) {
        //         return $item->restaurant->nama . '|' . $item->category;
        //     });

        //     // dd($groupedItems);

        //     $topDishes = OrderPivot::selectRaw('restaurant_id, SUM(qty) as total_qty')
        //     ->whereHas('order', function ($query) use ($month) {
        //         $query->where('status_pembayaran', 'Paid')
        //               ->whereMonth('created_at', $month);
        //     })
        //     ->groupBy('restaurant_id')
        //     ->orderByDesc('total_qty')
        //     ->limit(10)
        //     ->get();

        //     // dd($topDishes);
                            
        // } elseif ($type == 'yearly') {
        //     $year = $request->has('year') ? $request->year : date('Y');
        //     $orderDetails = OrderPivot::whereYear('created_at', $year)
        //                 ->whereHas('order', function ($query) {
        //                     $query->where('status_pembayaran', 'Paid');
        //                 })
        //                 ->orderBy('id', 'asc')
        //                 ->get();

        //     $orderTotal = Order::whereDate('created_at', $year)
        //                 ->where('status_pembayaran', 'Paid')
        //                 ->orderBy('id', 'asc')
        //                 ->get()->sum('total_price');

        //     $totalBartender = OrderPivot::whereDate('created_at', $year)
        //                     ->where('category', 'Minuman')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //     $totalKitchen = OrderPivot::whereDate('created_at', $year)
        //                     ->where('category', 'Makanan')
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->sum('harga_diskon');

        //     $totalFwb = Order::whereDate('created_at', $year)
        //                     ->whereNotNull('biliard_id')
        //                     ->sum('total_price');

        //     $topDishes = OrderPivot::selectRaw('restaurant_id, SUM(qty) as total_qty')
        //                     ->whereDate('created_at', $year)
        //                     ->whereHas('order', function ($query) {
        //                         $query->where('status_pembayaran', 'Paid');
        //                     })
        //                     ->groupBy('restaurant_id')
        //                     ->orderByDesc('total_qty')
        //                     ->limit(10)
        //                     ->get();
        // }

        if ($type == 'day') {
            // $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            // $statusPembayaran = 'Paid';
        
            // $baseOrderQuery = Order::where('status_pembayaran', $statusPembayaran);
        
            // if ($category) {
            //     $baseOrderQuery->where('category', $category);
            // }
        
            // $orderDetails = OrderPivot::with('order')
            //     ->whereDate('created_at', $date)
            //     ->whereHas('order', function ($query) use ($baseOrderQuery) {
            //         $query->mergeConstraintsFrom($baseOrderQuery);
            //     })
            //     ->orderBy('id', 'asc')
            //     ->get();
        
            // $orderTotal = $baseOrderQuery->whereDate('created_at', $date)->sum('total_price');
            // $service = $baseOrderQuery->whereDate('created_at', $date)->sum('service');
            // $pb01 = $baseOrderQuery->whereDate('created_at', $date)->sum('pb01');
        
            // $totalBartender = OrderPivot::whereDate('created_at', $date)
            //     ->where('category', 'Minuman')
            //     ->select('harga_diskon')
            //     ->whereHas('order', function ($query) use ($baseOrderQuery) {
            //         $query->mergeConstraintsFrom($baseOrderQuery);
            //     })
            //     ->sum('harga_diskon');
        
            // $totalKitchen = OrderPivot::whereDate('created_at', $date)
            //     ->where('category', 'Makanan')
            //     ->select('harga_diskon')
            //     ->whereHas('order', function ($query) use ($baseOrderQuery) {
            //         $query->mergeConstraintsFrom($baseOrderQuery);
            //     })
            //     ->sum('harga_diskon');
                
            //     $totalFwb = $baseOrderQuery->whereDate('created_at', $date)
            //     ->select('total_price')
            //     ->whereNotNull('biliard_id')
            //     ->sum('total_price');
        
            // $groupedItems = $orderDetails->groupBy(function ($item) {
            //     return $item->restaurant->nama . '|' . $item->category;
            // });
        
            // $topDishes = OrderPivot::selectRaw('order_pivots.restaurant_id, SUM(order_pivots.qty) as total_qty')
            //     ->join('orders', function ($join) use ($date) {
            //         $join->on('order_pivots.order_id', '=', 'orders.id')
            //             ->where('orders.status_pembayaran', 'Paid')
            //             ->whereDate('orders.created_at', $date);
            //     })
            //     ->groupBy('order_pivots.restaurant_id')
            //     ->orderByDesc('total_qty')
            //     ->limit(10)
            //     ->get();

            $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            if ($resto == 'All') {
                $orderDetails = OrderPivot::whereDate('created_at', $date)
                    ->whereHas('order', function ($query) {
                        $query->where('status_pembayaran', 'Paid');
                    })
                    ->when($category, function ($query) use ($category) {
                        return $query->where('category', $category);
                    })
                    ->orderBy('id', 'asc')
                    ->get();

                $orderTotal = Order::whereDate('created_at', $date)
                    ->where('status_pembayaran', 'Paid')
                    ->orderBy('id', 'asc')
                    ->get()->sum('total_price');

                $service = Order::whereDate('created_at', $date)
                ->where('status_pembayaran', 'Paid')
                ->sum('service');
                
                $pb01 = Order::whereDate('created_at', $date)
                ->where('status_pembayaran', 'Paid')
                ->sum('pb01');
                
                $totalBartender = OrderPivot::whereDate('created_at', $date)
                            ->where('category', 'Minuman')
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->sum(\DB::raw('harga_diskon * qty'));

                $totalKitchen = OrderPivot::whereDate('created_at', $date)
                            ->where('category', 'Makanan')
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->sum(\DB::raw('harga_diskon * qty'));

                $totalFwb = Order::whereDate('created_at', $date)
                            ->where('status_pembayaran', 'Paid')
                            ->sum('harga_diskon_billiard');

                // $groupedItems = $orderDetails->groupBy(function ($item) {
                //     return $item->restaurant->nama . '|' . $item->category;
                // });

                // $groupedKode = $orderDetails->groupBy(function ($item) {
                //     return $item->order->kode_meja . '|' . $item->order->jumlah_customer;
                // });

                $topDishes = OrderPivot::selectRaw('restaurant_id, SUM(qty) as total_qty')
                            ->whereDate('created_at', $date)
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->groupBy('restaurant_id')
                            ->orderByDesc('total_qty')
                            ->limit(10)
                            ->get();


            } else {
                $orderDetails = OrderPivot::whereDate('created_at', $date)
                            ->where('restaurant_id', $request->restaurant_id)
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->orderBy('id', 'asc')
                            ->get();

                $totalBartender = OrderPivot::whereDate('created_at', $date)
                            ->where('category', 'Minuman')
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->sum('harga_diskon');

                $totalKitchen = OrderPivot::whereDate('created_at', $date)
                            ->where('category', 'Makanan')
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->sum('harga_diskon');

                $totalFwb = Order::whereDate('created_at', $date)
                            ->whereNotNull('biliard_id')
                            ->sum('total_price');

                $topDishes = OrderPivot::selectRaw('restaurant_id, SUM(qty) as total_qty')
                            ->whereDate('created_at', $date)
                            ->whereHas('order', function ($query) {
                                $query->where('status_pembayaran', 'Paid');
                            })
                            ->groupBy('restaurant_id')
                            ->orderByDesc('total_qty')
                            ->limit(10)
                            ->get();
                }
        
        } elseif ($type == 'monthly') {
            $month = $request->has('month') ? date('m', strtotime($request->month)) : date('m');
            $statusPembayaran = 'Paid';

            $orderDetails = OrderPivot::with('order')
                ->join('orders', 'order_pivots.order_id', '=', 'orders.id')
                ->whereMonth('order_pivots.created_at', $month)
                ->where('orders.status_pembayaran', $statusPembayaran)
                ->orderBy('order_pivots.id', 'asc')
                ->get();

            $orderTotal = Order::whereMonth('created_at', $month)
                ->where('status_pembayaran', $statusPembayaran)
                ->sum('total_price');

            $totalBartender = OrderPivot::whereMonth('order_pivots.created_at', $month)
                ->where('order_pivots.category', 'Minuman') // Menggunakan "order_pivots.category"
                ->join('orders', 'order_pivots.order_id', '=', 'orders.id')
                ->where('orders.status_pembayaran', $statusPembayaran)
                ->sum('harga_diskon');

            $totalKitchen = OrderPivot::whereMonth('order_pivots.created_at', $month)
                ->where('order_pivots.category', 'Makanan') // Menggunakan "order_pivots.category"
                ->join('orders', 'order_pivots.order_id', '=', 'orders.id')
                ->where('orders.status_pembayaran', $statusPembayaran)
                ->sum('harga_diskon');

            $totalFwb = Order::whereMonth('created_at', $month)
                ->where('status_pembayaran', $statusPembayaran)
                ->whereNotNull('biliard_id')
                ->sum('total_price');

            // $groupedItems = $orderDetails->groupBy(function ($item) {
            //     return $item->restaurant->nama . '|' . $item->category;
            // });

            // $groupedKode = $orderDetails->groupBy(function ($item) {
            //     return $item->kasir_id->nama . '|' . $item->jumlah_customer;
            // });

            $topDishes = OrderPivot::selectRaw('order_pivots.restaurant_id, SUM(order_pivots.qty) as total_qty')
            ->join('orders', function ($join) use ($month) {
                $join->on('order_pivots.order_id', '=', 'orders.id')
                    ->where('orders.status_pembayaran', 'Paid')
                    ->whereMonth('orders.created_at', $month);
            })
            ->groupBy('order_pivots.restaurant_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        } elseif ($type == 'yearly') {
            $year = $request->has('year') ? $request->year : date('Y');
            $statusPembayaran = 'Paid';
        
            $baseOrderQuery = Order::where('status_pembayaran', $statusPembayaran);

            // $groupedItems = $orderDetails->groupBy(function ($item) {
            //     return $item->restaurant->nama . '|' . $item->category;
            // });

            // $groupedKode = $orderDetails->groupBy(function ($item) {
            //     return $item->kasir_id->nama . '|' . $item->jumlah_customer;
            // });
        
            $orderDetails = OrderPivot::with('order')
                ->whereYear('created_at', $year)
                ->whereHas('order', function ($query) use ($baseOrderQuery) {
                    $query->mergeConstraintsFrom($baseOrderQuery);
                })
                ->orderBy('id', 'asc')
                ->get();
        
                $orderTotal = $baseOrderQuery->select('total_price')->whereYear('created_at', $year)->sum('total_price');
        
            $totalBartender = OrderPivot::whereYear('created_at', $year)
                ->select('harga_diskon')
                ->where('category', 'Minuman')
                ->whereHas('order', function ($query) use ($baseOrderQuery) {
                    $query->mergeConstraintsFrom($baseOrderQuery);
                })
                ->sum('harga_diskon');
        
            $totalKitchen = OrderPivot::whereYear('created_at', $year)
                ->select('harga_diskon')
                ->where('category', 'Makanan')
                ->whereHas('order', function ($query) use ($baseOrderQuery) {
                    $query->mergeConstraintsFrom($baseOrderQuery);
                })
                ->sum('harga_diskon');
        
            $totalFwb = $baseOrderQuery->whereYear('created_at', $year)
                ->select('total_price')
                ->whereNotNull('biliard_id')
                ->sum('total_price');
        
                $topDishes = OrderPivot::selectRaw('order_pivots.restaurant_id, SUM(order_pivots.qty) as total_qty')
                ->join('orders', function ($join) use ($year) {
                    $join->on('order_pivots.order_id', '=', 'orders.id')
                        ->where('orders.status_pembayaran', 'Paid')
                        ->whereYear('orders.created_at', $year);
                })
                ->groupBy('order_pivots.restaurant_id')
                ->orderByDesc('total_qty')
                ->limit(10)
                ->get();
        }

        $data['total_price'] = $orderTotal;
        $data['service'] = $service;
        $data['pb01'] = $pb01;
        $data['total_qty'] = $orderDetails->sum('qty');
        $data['order_details'] = $orderDetails;
        $data['total_bartender'] = $totalBartender;
        $data['total_kitchen'] = $totalKitchen;
        $data['total_fwb'] = $totalFwb;
        // $data['groupedItems'] = $groupedItems;
        // $data['groupedKode'] = $groupedKode;

        $dishNames = [];
        $dishQuantities = [];

        foreach ($topDishes as $dish) {
            $dishNames[] = $dish->restaurant->nama; // Assuming you have a relationship to get product name
            $dishQuantities[] = $dish->total_qty;

        }

        $data['dishNames'] = $dishNames;
        $data['dishQuantities'] = $dishQuantities;

        return view('report-analytic.index', $data);

    }
}
