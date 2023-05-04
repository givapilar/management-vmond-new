<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use DateTime;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';
        $data['materials'] = Material::orderby('id', 'asc')->get();
        $data['stock_masuk'] = StokMasuk::get()->sum('material_masuk');
        $data['stock_keluar'] = StokKeluar::get()->sum('material_keluar');
        
        
        // Target Min dan Max
        $min = Material::get();

        $target_material_min = $min->sum('material_masuk');

        $data['start_date'] = $request->dateMonth;
        $data['status'] = 'generate';
        // $data['max'] = MrpInventoryMaterialList::orderBy('created_at','desc')->get();

        if ($request->typeInterval == 'daily') {
            $data_start = $request->dateMonth;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else if( $request->typeInterval == 'monthly' ){
            $data_start = $request->dateYear;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else{
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }

        if($request->type == 'Material'){
            $data['inventory'] =  MrpInventoryMaterialList::orderBy('id', 'asc')->get();
            
            for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
                array_push($data['date'], $day->format('d'));
                $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material_out = MrpInventoryMaterialOut::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                $material_list = MrpInventoryMaterialList::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
                
                $stock_in_material = $material_incoming->sum('material_incoming');
                $stock_out_material = $material_out->sum('material_outgoing');
                
                $diff_stock_material = $material_list->sum('stock');
                
                if ($material_list->sum('total_target_day') == 0) {
                    $target_material = 0;
                }else{
                    $target_material =  round($material_list->sum('stock') / $material_list->sum('total_target_day')) ;
                    
                }
                
                array_push($data['stock_in_material'], $stock_in_material);
                array_push($data['stock_out_material'], $stock_out_material);
                array_push($data['diff_stock_material'], $diff_stock_material);
                array_push($data['target_material'], $target_material);

            }
        }
        return view('dashboard.index', $data);
    }
}
