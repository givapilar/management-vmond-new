<?php

namespace App\Http\Controllers;

use App\Models\AccountUser;
use App\Models\Biliard;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MejaControl;
use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:dashboard-control-list', ['only' => 'dashboardControl']);
        $this->middleware('permission:dashboard-control-create', ['only' => ['storeDashboardControl']]);
        $this->middleware('permission:dashboard-control-edit', ['only' => ['updateDashboardControl']]);
        $this->middleware('permission:dashboard-control-delete', ['only' => ['destroyDashboardControl']]);
    }

    // public function index(Request $request)
    // {
    //     $data['page_title'] = 'Customer';
    //     $data['materials'] = Material::orderby('id', 'asc')->get();
    //     $data['restaurants'] = Restaurant::orderby('id', 'asc')->get();
    //     $data['account_users'] = AccountUser::orderby('id', 'asc')->get();
    //     $data['type'] = $request->type;
    //     $type = $request->type ?? 'monthly';
    //     if ($request->year) {
    //         $year = date('Y', $request->year);
    //     } else {
    //         $year = date('Y');
    //     }

    //     $data['start_date'] = $request->start_date;
    //     $data['date'] = [];
    //     $data['stok_masuk'] = [];
    //     $data['stok_keluar'] = [];
    //     // dd($type);
    //     if ($type == 'day') {
    //         $data['stock_masuk'] = StokMasuk::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get()->sum('material_masuk');
    //         $data['stock_keluar'] = StokKeluar::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get()->sum('material_keluar');

    //     } elseif($type == 'monthly') {
    //         $data['stock_masuk'] = StokMasuk::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get()->sum('material_masuk');
    //         $data['stock_keluar'] = StokKeluar::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get()->sum('material_keluar');
    //         if ($request->start_date) {
    //             $start_date = new DateTime(Carbon::parse($request->month)->format('Y/m/d') . '00:00:00');
    //             $end_date = new DateTime(Carbon::parse($request->month)->endOfMonth()->format('Y/m/t') . '23:59:59');
    //             // dd($start_date, $end_date, $request->start_date);
    //         } else {
    //             // dd("asd");
    //             $start_date = new DateTime(date('Y/m/01 00:00:00'));
    //             $end_date = new DateTime(date('Y/m/t 23:59:59'));
    //         }

    //         for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
    //             array_push($data['date'], $day->format('d'));
    //              $stok_masuk = StokMasuk::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->when($request->material_id, function($q) use($request){{
    //                 return $q->where('material_id', $request->material_id);
    //             }})->get();
    //              $stok_keluar = StokKeluar::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->when($request->material_id, function($q) use($request){{
    //                 return $q->where('material_id', $request->material_id);
    //             }})->get();
    //              $masuk = $stok_masuk->sum('material_masuk');
    //              $keluar = $stok_keluar->sum('material_keluar');

    //             array_push($data['stok_masuk'], $masuk);
    //             array_push($data['stok_keluar'], $keluar);
    //         }
    //     } elseif ($type == 'yearly') {
    //         $data['stock_masuk'] = StokMasuk::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get()->sum('material_masuk');
    //         $data['stock_keluar'] = StokKeluar::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get()->sum('material_keluar');
    //         $year = $request->year;

    //         $stok_masuk_data = [];
    //         $stok_keluar_data = [];
    //         $stok_masuk = StokMasuk::whereYear('created_at', $year)->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get();
    //         $stok_keluar = StokKeluar::whereYear('created_at', $year)->when($request->material_id, function($q) use($request){{
    //             return $q->where('material_id', $request->material_id);
    //          }})->get();
    //         // dd($stok_keluar);
    //         foreach ($stok_masuk as $value) {
    //             $bulan = date('m', strtotime($value->created_at));
    //             $stok_masuk_data[$bulan][] = $value->material_masuk;
    //         }
    //         foreach ($stok_keluar as $value) {
    //             $bulan = date('m', strtotime($value->created_at));
    //             $stok_keluar_data[$bulan][] = $value->material_keluar;
    //         }
    //         // dd($stok_keluar_data);
    //         $monthList = [
    //             '01' => 'Jan',
    //             '02' => 'Feb',
    //             '03' => 'Mar',
    //             '04' => 'Apr',
    //             '05' => 'May',
    //             '06' => 'Jun',
    //             '07' => 'Jul',
    //             '08' => 'Aug',
    //             '09' => 'Sep',
    //             '10' => 'Okt',
    //             '11' => 'Nov',
    //             '12' => 'Dec',
    //         ];
    //         // dd($stock)
    //         $dataCharts = [];
    //         foreach ($monthList as $key => $value) {
    //             if (($stok_masuk_data[$key] ?? false) && ($stok_keluar_data[$key] ?? false)) {
    //                 $dataChart = [
    //                     'month' => $value,
    //                     'val_masuk' => array_sum($stok_masuk_data[$key]),
    //                     'val_keluar' => array_sum($stok_keluar_data[$key]),
    //                 ];
    //             } elseif($stok_masuk_data[$key] ?? false) {
    //                 $dataChart = [
    //                     'month' => $value,
    //                     'val_masuk' => array_sum($stok_masuk_data[$key]),
    //                     'val_keluar' => 0,
    //                 ];
    //             } elseif($stok_keluar_data[$key] ?? false) {
    //                 $dataChart = [
    //                     'month' => $value,
    //                     'val_masuk' => 0,
    //                     'val_keluar' => array_sum($stok_keluar_data[$key]),
    //                 ];
    //             } else {
    //                 $dataChart = [
    //                     'month' => $value,
    //                     'val_masuk' => 0,
    //                     'val_keluar' => 0,
    //                 ];
    //             }
    //             $dataCharts[] = $dataChart;
    //         }

    //         // dd($dataCharts);
    //         $data['stok_masuk'] = array_column($dataCharts, 'val_masuk');
    //         $data['stok_keluar'] = array_column($dataCharts, 'val_keluar');
    //         $data['date'] = array_column($dataCharts, 'month');
    //     }


    //     $data['membershipBronze'] = AccountUser::whereHas('membership', function ($query) {
    //         $query->where('level', 'Bronze');
    //     })->count();

    //     $data['membershipSilver'] = AccountUser::whereHas('membership', function ($query) {
    //         $query->where('level', 'Silver');
    //     })->count();

    //     $data['membershipGold'] = AccountUser::whereHas('membership', function ($query) {
    //         $query->where('level', 'Gold');
    //     })->count();

    //     $data['membershipPlatinum'] = AccountUser::whereHas('membership', function ($query) {
    //         $query->where('level', 'Platinum');
    //     })->count();

    //     $data['membershipSuperPlatinum'] = AccountUser::whereHas('membership', function ($query) {
    //         $query->where('level', 'Super Platinum');
    //     })->count();

    //     $data['restaurants'] = Restaurant::orderBy('id', 'asc')->get();
    //     $data['order'] = Order::orderBy('id', 'asc')->get();
    //     $orderDetail = OrderPivot::orderBy('id', 'asc')->get();

    //     // Collect food sales data
    //     // $foodSalesData = [];

    //     // foreach ($orderDetail as $orderPivot) {
    //     //     $foodName = $orderPivot->restaurant->nama;
    //     //     $qty = $orderPivot->qty;

    //     //     if (!isset($foodSalesData[$foodName])) {
    //     //         $foodSalesData[$foodName] = 0;
    //     //     }

    //     //     $foodSalesData[$foodName] += $qty;
    //     // }

    //     // // Prepare data for the chart
    //     // $chartData = [
    //     //     'labels' => array_keys($foodSalesData),
    //     //     'datasets' => [
    //     //         [
    //     //             'label' => 'Food Sales Quantity',
    //     //             'data' => array_values($foodSalesData),
    //     //             'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
    //     //             'borderColor' => 'rgba(75, 192, 192, 1)',
    //     //             'borderWidth' => 2
    //     //         ]
    //     //     ]
    //     // ];
    //     // $data['chartData'] = $chartData;  

    //     return view('dashboard.index', $data);
        
    // }

    public function index(Request $request){
        $data['page_title'] = 'Customer';
        $data['materials'] = Material::orderBy('id', 'asc')->get();
        // $data['account_users'] = AccountUser::orderBy('id', 'asc')->get();
        $data['type'] = $request->type ?? 'monthly';

        // Handle date-related logic more efficiently
        $startDate = $request->start_date ?: date('Y/m/01 00:00:00');
        $endDate = $request->start_date ? date('Y/m/t 23:59:59', strtotime($request->month)) : date('Y/m/t 23:59:59');

        // Fetch stock data for the selected type
        $data['stock_masuk'] = $this->getStockData('App\Models\StokMasuk', $request, $startDate, $endDate);
        $data['stock_keluar'] = $this->getStockData('App\Models\StokKeluar', $request, $startDate, $endDate);

        $data['date'] = $this->getDateRange($startDate, $endDate);

        // Fetch membership counts
        $data['membershipBronze'] = $this->getMembershipCount('Bronze');
        $data['membershipSilver'] = $this->getMembershipCount('Silver');
        $data['membershipGold'] = $this->getMembershipCount('Gold');
        $data['membershipPlatinum'] = $this->getMembershipCount('Platinum');
        $data['membershipSuperPlatinum'] = $this->getMembershipCount('SuperPlatinum');
        // ...

        
        $monthList = [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nov',
            '12' => 'Dec',
        ];
        // dd($stock)
        $dataCharts = [];
        foreach ($monthList as $key => $value) {
            if (($stok_masuk_data[$key] ?? false) && ($stok_keluar_data[$key] ?? false)) {
                $dataChart = [
                    'month' => $value,
                    'val_masuk' => array_sum($stok_masuk_data[$key]),
                    'val_keluar' => array_sum($stok_keluar_data[$key]),
                ];
            } elseif($stok_masuk_data[$key] ?? false) {
                $dataChart = [
                    'month' => $value,
                    'val_masuk' => array_sum($stok_masuk_data[$key]),
                    'val_keluar' => 0,
                ];
            } elseif($stok_keluar_data[$key] ?? false) {
                $dataChart = [
                    'month' => $value,
                    'val_masuk' => 0,
                    'val_keluar' => array_sum($stok_keluar_data[$key]),
                ];
            } else {
                $dataChart = [
                    'month' => $value,
                    'val_masuk' => 0,
                    'val_keluar' => 0,
                ];
            }
            $dataCharts[] = $dataChart;
        }

        // dd($dataCharts);
        $data['stok_masuk'] = array_column($dataCharts, 'val_masuk');
        $data['stok_keluar'] = array_column($dataCharts, 'val_keluar');

        return view('dashboard.index', $data);
    }

    private function getStockData($model, $request, $startDate, $endDate)
    {
        return $model::whereBetween('created_at', [$startDate, $endDate])
            ->when($request->material_id, function ($q) use ($request) {
                return $q->where('material_id', $request->material_id);
            })
            ->get()
            ->sum('material_masuk');
    }

    private function getDateRange($startDate, $endDate)
    {
        $dateRange = [];
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        for ($day = clone $start; $day <= $end; $day->modify('+1 day')) {
            $dateRange[] = $day->format('d');
        }

        return $dateRange;
    }

    private function getMembershipCount($level)
    {
        return AccountUser::whereHas('membership', function ($query) use ($level) {
            $query->where('level', $level);
        })->count();
    }



    public function dashboardControl() {
        $data['page_title'] = 'Dashboard Control';
        $data['meja_controls'] = MejaControl::orderBy('id', 'ASC')->get();
        $data['billiards'] = Biliard::orderBy('id', 'ASC')->get();

        return view('dashboard-control.index', $data);
    }

    public function storeDashboardControl(Request $request) {
        $validate = $request->validate([
            'address' => 'required',
            'billiard_id' => 'required|unique:meja_controls,billiard_id'
        ]);

        try {
            $dataControl = new MejaControl();

            $dataControl->address = $validate['address'];
            $dataControl->billiard_id = $validate['billiard_id'];

            $dataControl->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Controller '.$dataControl->Billiard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('control-lamp')->with(['success' => 'Controller added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('control-lamp')->with(['failed' => 'Failed'.$th->getMessage()]);
        }
    }

    function updateDashboardControl(Request $request, $id) {
        $validate = $request->validate([
            'address' => 'required',
            'billiard_id_update' => 'required|unique:meja_controls,billiard_id,'.$id
        ]);

        try {
            $dataControl = MejaControl::findOrFail($id);

            $dataControl->address = $validate['address'];
            $dataControl->billiard_id = $validate['billiard_id_update'];

            $dataControl->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Controller '.$dataControl->Billiard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('control-lamp')->with(['success' => 'Controller edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('control-lamp')->with(['failed' => 'Failed'.$th->getMessage()]);
        }
    }

    public function destroyDashboardControl($id)
    {
        DB::transaction(function () use ($id) {
            $dataControl = MejaControl::findOrFail($id);

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete Controller '. $dataControl->Billiard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $dataControl->delete();
        });

        Session::flash('success', 'Controller deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
