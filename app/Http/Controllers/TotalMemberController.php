<?php

namespace App\Http\Controllers;

use App\Models\AccountUser;
use App\Models\Order;
use Illuminate\Http\Request;

class TotalMemberController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Total Membership';

        $data['account_users'] = AccountUser::get();

        $data['membershipBronze'] = AccountUser::whereHas('membership', function ($query) {
            $query->where('level', 'Bronze');
        })->count();

        $data['membershipSilver'] = AccountUser::whereHas('membership', function ($query) {
            $query->where('level', 'Silver');
        })->count();

        $data['membershipGold'] = AccountUser::whereHas('membership', function ($query) {
            $query->where('level', 'Gold');
        })->count();

        $data['membershipPlatinum'] = AccountUser::whereHas('membership', function ($query) {
            $query->where('level', 'Platinum');
        })->count();

        $data['membershipSuperPlatinum'] = AccountUser::whereHas('membership', function ($query) {
            $query->where('level', 'Super Platinum');
        })->count();

        return view('master-data.total-member.index', $data);


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
