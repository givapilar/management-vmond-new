<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportAnalyticController extends Controller
{
    public function index(Request $request)
    {
        $data['restaurants'] = Restaurant::orderBy('id', 'asc')->get();
        $data['order'] = Order::orderBy('id', 'asc')->get();
        $orderDetails = OrderPivot::orderBy('id', 'asc')->get();

        // Initialize an empty array to store food sales data
        $foodSalesData = [];

        $startDate = $request->input('start_date');

        // Jika belum ada tanggal yang dipilih, atur tanggal hari ini
        if (!$startDate) {
            $startDate = now()->format('Y-m-d');
        }

        // Loop melalui detail pesanan dan mengisi array data penjualan makanan
        foreach ($orderDetails as $orderDetail) {
            $foodName = $orderDetail->restaurant->nama;
            $quantity = $orderDetail->qty;
            $orderDate = $orderDetail->order->created_at;

            // Filter berdasarkan periode yang dipilih
            if ($request->has('type')) {
                $type = $request->input('type');
                if ($type === 'day' && ($orderDate->isToday() || $orderDate->format('Y-m-d') === $startDate)) {
                    // Jika tipe adalah harian dan tanggal pesanan adalah hari ini atau tanggal yang dipilih
                    $this->addToFoodSalesData($foodSalesData, $foodName, $quantity);
                } elseif ($type === 'monthly' && $orderDate->isCurrentMonth()) {
                    // Jika tipe adalah bulanan dan tanggal pesanan adalah bulan ini
                    $this->addToFoodSalesData($foodSalesData, $foodName, $quantity);
                } elseif ($type === 'yearly' && $orderDate->isCurrentYear()) {
                    // Jika tipe adalah tahunan dan tanggal pesanan adalah tahun ini
                    $this->addToFoodSalesData($foodSalesData, $foodName, $quantity);
                }
            }
        }

        $chartOption = [
            'title' => [
                'text' => 'Food Sales'
            ],
            'tooltip' => [
                'trigger' => 'axis'
            ],
            'xAxis' => [
                'type' => 'category',
                'data' => array_keys($foodSalesData) // Use food names as categories
            ],
            'yAxis' => [
                'type' => 'value'
            ],
            'series' => [
                [
                    'name' => 'Quantity',
                    'type' => 'line',
                    'data' => array_values($foodSalesData) // Use quantities as data
                ]
            ]
        ];

        $data['chartOption'] = $chartOption;

        return view('report-analytic.index', $data);
    }
}
