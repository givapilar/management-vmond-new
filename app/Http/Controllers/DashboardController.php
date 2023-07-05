<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MejaControl;
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

    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';
        $data['materials'] = Material::orderby('id', 'asc')->get();
        $data['type'] = $request->type;
        $type = $request->type ?? 'monthly';
        if ($request->year) {
            $year = date('Y', $request->year);
        } else {
            $year = date('Y');
        }

        $data['start_date'] = $request->start_date;
        $data['date'] = [];
        $data['stok_masuk'] = [];
        $data['stok_keluar'] = [];
        // dd($type);
        if ($type == 'day') {
            $data['stock_masuk'] = StokMasuk::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get()->sum('material_masuk');
            $data['stock_keluar'] = StokKeluar::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get()->sum('material_keluar');
            // $start_date = new DateTime(date('Y-m-d 00:00:00',strtotime($request->start_date)) ?? date('Y-m-d 00:00:00'));
            // $end_date = new DateTime(date('Y-m-d 23:59:59',strtotime($request->start_date)) ?? date('Y-m-d 23:59:59'));
            // for($hour = clone $start_date; $hour <= $end_date; $hour->modify('+1 hour')){
            //     array_push($data['date'], $hour->format('H'));
            //     $stok_masuk = StokMasuk::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->get();
            //     $stok_keluar = StokKeluar::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->get();
            //     $masuk = $stok_masuk->sum('material_masuk');
            //     $keluar = $stok_keluar->sum('masterial_keluar');
            // }
            // return false;
        } elseif($type == 'monthly') {
            $data['stock_masuk'] = StokMasuk::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get()->sum('material_masuk');
            $data['stock_keluar'] = StokKeluar::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get()->sum('material_keluar');
            if ($request->start_date) {
                $start_date = new DateTime(Carbon::parse($request->month)->format('Y/m/d') . '00:00:00');
                $end_date = new DateTime(Carbon::parse($request->month)->endOfMonth()->format('Y/m/t') . '23:59:59');
                // dd($start_date, $end_date, $request->start_date);
            } else {
                // dd("asd");
                $start_date = new DateTime(date('Y/m/01 00:00:00'));
                $end_date = new DateTime(date('Y/m/t 23:59:59'));
            }

            for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                 $stok_masuk = StokMasuk::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                }})->get();
                 $stok_keluar = StokKeluar::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')])->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                }})->get();
                 $masuk = $stok_masuk->sum('material_masuk');
                 $keluar = $stok_keluar->sum('material_keluar');

                array_push($data['stok_masuk'], $masuk);
                array_push($data['stok_keluar'], $keluar);
            }
        } elseif ($type == 'yearly') {
            $data['stock_masuk'] = StokMasuk::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get()->sum('material_masuk');
            $data['stock_keluar'] = StokKeluar::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get()->sum('material_keluar');
            $year = $request->year;

            $stok_masuk_data = [];
            $stok_keluar_data = [];
            $stok_masuk = StokMasuk::whereYear('created_at', $year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
            $stok_keluar = StokKeluar::whereYear('created_at', $year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
            // dd($stok_keluar);
            foreach ($stok_masuk as $value) {
                $bulan = date('m', strtotime($value->created_at));
                $stok_masuk_data[$bulan][] = $value->material_masuk;
            }
            foreach ($stok_keluar as $value) {
                $bulan = date('m', strtotime($value->created_at));
                $stok_keluar_data[$bulan][] = $value->material_keluar;
            }
            // dd($stok_keluar_data);
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
            $data['date'] = array_column($dataCharts, 'month');
        }



        return view('dashboard.index', $data);
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

            return redirect()->route('dashboard-control')->with(['success' => 'Controller added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('dashboard-control')->with(['failed' => 'Failed'.$th->getMessage()]);
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

            return redirect()->route('dashboard-control')->with(['success' => 'Controller edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('dashboard-control')->with(['failed' => 'Failed'.$th->getMessage()]);
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
