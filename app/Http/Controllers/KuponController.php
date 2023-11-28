<?php

namespace App\Http\Controllers;

use App\Models\Kupon;
use Illuminate\Http\Request;

class KuponController extends Controller
{
    public function index(){
        $data['kupons'] = Kupon::get();
        return view('master-data.kupon.index',$data);
    }
}
