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

        // Loop through the order details and populate the food sales data array
        foreach ($orderDetails as $orderDetail) {
            $foodName = $orderDetail->restaurant->nama;
            $quantity = $orderDetail->qty;

            if (array_key_exists($foodName, $foodSalesData)) {
                // Increment the quantity for the existing food name
                $foodSalesData[$foodName] += $quantity;
            } else {
                // Add a new entry for the food name with its quantity
                $foodSalesData[$foodName] = $quantity;
            }
        }

        // Now, $foodSalesData contains the food sales data with food names as keys and quantities as values
        // You can use this data to create a chart

        // Example ECharts option for creating a bar chart
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
