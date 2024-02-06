<?php

namespace App\Http\Controllers;

use App\Models\AccountUser;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function customerData(Request $request){
        $data['page_title'] = 'Customer Data';
        $data['account_users'] = AccountUser::get();
    
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
            } else {
                // dd('masuk2');
                $stok = Order::whereDate('created_at', $date)
                            ->where('user_id', $request->user_id)
                            ->where('status_pembayaran', 'Paid')
                            ->orderBy('id', 'asc')
                            ->get();
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
        } elseif ($type == 'yearly') {
            $year = $request->has('year') ? $request->year : date('Y');
            $stok = Order::whereYear('created_at', $year)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->where('status_pembayaran', 'Paid')
                        ->orderBy('id', 'asc')
                        ->get();
        }

        $groupedOrders = $stok->groupBy('user.username');

        $data['total_price'] = 0; // Initialize total_price
        $data['orders'] = [];
        
        // Loop through grouped orders and calculate total price for each user
        foreach ($groupedOrders as $username => $userOrders) {
            $totalPrice = $userOrders->sum('total_price');

            $email = $userOrders->first()->user->email;
            $telephone = $userOrders->first()->user->telephone;
            $membership = $userOrders->first()->user->membership->level;
            
            // Add the user data to the $data['orders'] array
            $data['orders'][] = [
                'username' => $username,
                'email' => $email,
                'telephone' => $telephone,
                'membership' => $membership,
                'total_price' => $totalPrice,
            ];
        
            // Update the total_price
            $data['total_price'] += $totalPrice;
        }

        
        return view('master-data.customer.index',$data);
    }
}
