<?php

namespace App\Http\Controllers;

use App\Models\AccountUser;
use App\Models\Order;
use App\Models\OrderBilliard;
use App\Models\OrderMeeting;
use App\Models\OrderPivot;
use App\Models\OtherSettings;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;



class DashboardBartenderController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard';  
        // $data['orders'] = OrderPivot::get();
        // $data['order_table'] = Order::get();
            
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');
        // $data['orders'] = Order::get();
        $today = Carbon::today();
        $orders = Order::orderBy('id','desc')->where('status_pembayaran', 'Paid')->whereDate('created_at', $today)->where('status_pesanan', 'process')->get();
        $data['orders'] = $orders;
        // dd($orders[0]->orderPivotMakanan());
        // $data['order_billiards'] = $order->orderBilliardMakananTime($current_time);
        // $data['order_meetings'] = $order->orderMeetingMakananTime($current_time);
        // $data['order_billiards'] = OrderBilliard::get();
        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }

        return view('process.bartender.dashboard',$data);
    }

    public function calculateElapsedTime($createdAt)
    {
        $now = Carbon::now();
        $created = Carbon::parse($createdAt);
        $elapsedTime = $created->diffForHumans($now);

        return $elapsedTime;
    }

    public function detail($id)
    {
        $data['orders'] = Order::findorFail($id);
        $data['orders_pivots'] = OrderPivot::get();

        return view('process.bartender.index',$data);
    }

    public function statusDashboard(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = $request->type;
            if ($type == 'pivot') {
                $order = OrderPivot::where('id', $request->id)->first();
                
                $order->status_pemesanan = 'Selesai';
                $order->save();
            }elseif ($type == 'meeting') {
                $order = OrderMeeting::where('id', $request->id)->first();
                
                $order->status_pemesanan = 'Selesai';
                $order->save();
            }elseif ($type == 'billiard') {
                $order = OrderBilliard::where('id', $request->id)->first();
                
                $order->status_pemesanan = 'Selesai';
                $order->save();
            }

            // Status Order
            $statusPivot = false;
            $statusMeeting = false;
            $statusBilliard = false;
            // Check All Order
            $orderMaster = Order::where('id', $order->order_id)->first();
            // Count OrderPivot
            $orderPivot = OrderPivot::where('order_id', $orderMaster->id)->get()->count();
            $orderPivotDone = OrderPivot::where('order_id', $orderMaster->id)->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderPivot == $orderPivotDone) {
                $statusPivot = true;
            }
            // Count OrderMeeting
            $orderMeeting = OrderMeeting::where('order_id', $orderMaster->id)->get()->count();
            $orderMeetingDone = OrderMeeting::where('order_id', $orderMaster->id)->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderMeeting == $orderMeetingDone) {
                $statusMeeting = true;
            }
            // Count OrderBilliard
            $orderBilliard = OrderBilliard::where('order_id', $orderMaster->id)->get()->count();
            $orderBilliardDone = OrderBilliard::where('order_id', $orderMaster->id)->where('status_pemesanan', 'Selesai')->get()->count();
            if ($orderBilliard == $orderBilliardDone) {
                $statusBilliard = true;
            }

            if ($statusPivot && $statusMeeting && $statusBilliard) {
                $orderMaster->status_pesanan = 'Done';
                $orderMaster->save();
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function statusRemove(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = $request->type;
            if ($type == 'pivot') {
                $order = OrderPivot::where('id', $request->id)->first();
                
                $order->status_pemesanan = null;
                $order->save();
            }elseif ($type == 'meeting') {
                $order = OrderMeeting::where('id', $request->id)->first();
                
                $order->status_pemesanan = null;
                $order->save();
            }elseif ($type == 'billiard') {
                $order = OrderBilliard::where('id', $request->id)->first();
                
                $order->status_pemesanan = null;
                $order->save();
            }
            // Check All Order
            $orderMaster = Order::where('id', $order->order_id)->first();
            $orderMaster->status_pesanan = 'process';
            $orderMaster->save();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
   
    public function statusDashboardAll(Request $request)
    {
        try {
            $order = OrderPivot::where('order_id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function show($id)
    {
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');

        $orders = Order::findOrFail($id);
        $data['other_setting'] = OtherSettings::get()->first();
        $data['order_billiard'] = OrderBilliard::get();
    
        if ($orders->status_pembayaran !== 'Paid' || $orders->status_pesanan == null) {
            abort(404);
        }
    
        $data['orders'] = $orders;
       	// $pdf = PDF::loadview('process.kitchen.pdf',$data);
        return PDF::loadview('process.bartender.pdf', $data)->stream('order-' . $orders->id . '.pdf');
    	// return $pdf->download('order-'.$orders->id.'.pdf');
    }

    public function autoPrintButton(Request $request,$id){
        $orderMaster = Order::where('id', $request->id)->first();
        $userAccount = AccountUser::where('id', $orderMaster->user_id)->first();
        $orderPivot = OrderPivot::where('order_id', $orderMaster->id)->where('category', 'Minuman')->get();
        $orderBilliard = OrderBilliard::where('order_id', $orderMaster->id)->where('category', 'Minuman')->get();
        

        // Order Minuman
        $orders = Order::where('status_pembayaran', 'Paid')->orderBy('id', 'DESC')->get();
        

        $connector = new NetworkPrintConnector("192.168.18.17", 9100);
        $printer = new Printer($connector);
        
        /* Initialize */
        $printer -> initialize();

        // membuat fungsi untuk membuat 1 baris tabel, agar dapat dipanggil berkali-kali dgn mudah
        function buatBaris4Kolom($kolom1, $kolom2,$kolom3) {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 4;
            $lebar_kolom_2 = 15;
            $lebar_kolom_3 = 15;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
            $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);
            $kolom3Array = explode("\n", $kolom3);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");
                $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ");

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 ;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode($hasilBaris, "\n") . "\n";
        }   

        // Membuat judul
        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
        $printer->text("VMOND Coffee & Eatery Space\n");
        $printer->text("\n");

        // Data transaksi
        $printer->initialize();
        $printer->text("No Inv : ".$orderMaster->invoice_no."\n");
        $printer->text("Customer : ".$orderMaster->name."\n");
        if ($orderMaster->kasir_id) {
        $printer->text("Kasir : ".$orderMaster->userManagement->name."\n");
        }
        $printer->text("Waktu : ".date('Y-m-d H:i:s')."\n");

        if ($orderMaster->meja_restaurant_id) {
            $printer->text("Table : ".$orderMaster->tableRestaurant->nama."\n");

             // Membuat tabel
            $printer->initialize(); // Reset bentuk/jenis teks
            $printer->text("----------------------------------------\n");
            $printer->text(buatBaris4Kolom("qty", "Description", "Note"));
            $printer->text("----------------------------------------\n");

            // punya sahri
            foreach ($orderPivot as $key => $order) {
                $restaurantMenu = Restaurant::where('id', $order->restaurant_id)->first();
                if ($order->category ==  'Minuman') {
                    $addOn = '';
                    foreach ($order->orderAddOn as $key => $oad) {
                        $addOn .= $oad->addOnDetail->nama. ', ';
                    }
                    $printer->text(buatBaris4Kolom($order->qty, $restaurantMenu->nama, $addOn));
                    $printer->text("----------------------------------------\n");
                    
                }
            }
        }else if($orderMaster->biliard_id){
            $printer->text("Table : ".$orderMaster->tableBilliard->nama."\n");

             // Membuat tabel
            $printer->initialize(); // Reset bentuk/jenis teks
            $printer->text("----------------------------------------\n");
            $printer->text(buatBaris4Kolom("qty", "Description", "Note"));
            $printer->text("----------------------------------------\n");

            // punya sahri
            foreach ($orderBilliard as $key => $order) {
                $restaurantMenu = Restaurant::where('id', $order->restaurant_id)->first();
                if ($order->category ==  'Minuman') {
                    $addOn = '-                         ';
                    // foreach ($order->orderAddOn as $key => $oad) {
                    //     $addOn .= $oad->addOnDetail->nama. ', ';
                    // }
                    $printer->text(buatBaris4Kolom($order->qty, $restaurantMenu->nama, $addOn));
                    $printer->text("----------------------------------------\n");
                    
                }
            }
        }else if($orderMaster->meeting_room_id){
            $printer->text("Table : ".$orderMaster->tableMeetingRoom->nama."\n");
        }else if($orderMaster->category == 'Takeaway'){
            $printer->text("Pesanan : Takeaway"."\n");

             // Membuat tabel
             $printer->initialize(); // Reset bentuk/jenis teks
             $printer->text("----------------------------------------\n");
             $printer->text(buatBaris4Kolom("qty", "Description", "Note"));
             $printer->text("----------------------------------------\n");
 
             // punya sahri
             foreach ($orderPivot as $key => $order) {
                 $restaurantMenu = Restaurant::where('id', $order->restaurant_id)->first();
                 if ($order->category ==  'Minuman') {
                     $addOn = '';
                     foreach ($order->orderAddOn as $key => $oad) {
                         $addOn .= $oad->addOnDetail->nama. ', ';
                     }
                     $printer->text(buatBaris4Kolom($order->qty, $restaurantMenu->nama, $addOn));
                     $printer->text("----------------------------------------\n");
                     
                 }
             }
        }


        // Membuat tabel
        // $printer->initialize(); // Reset bentuk/jenis teks
        // $printer->text("----------------------------------------\n");
        // $printer->text(buatBaris4Kolom("qty", "Description", "Note"));
        // $printer->text("----------------------------------------\n");

        // // punya sahri
        // foreach ($orderPivot as $key => $order) {
        //     $restaurantMenu = Restaurant::where('id', $order->restaurant_id)->first();
        //     if ($order->category ==  'Minuman') {
        //         $addOn = '';
        //         foreach ($order->orderAddOn as $key => $oad) {
        //             $addOn .= $oad->addOnDetail->nama. ', ';
        //         }
        //         $printer->text(buatBaris4Kolom($order->qty, $restaurantMenu->nama, $addOn));
        //         $printer->text("----------------------------------------\n");
                
        //     }
        // }
        // Punya syahrul
        // foreach ($orders->orderPivotMinuman() as $key => $order) {
        //     $restaurantMenu = Restaurant::where('id', $order->restaurant_id)->first();
        //     if ($order->category ==  'Minuman') {
        //         $printer->text(buatBaris4Kolom($order->qty, $restaurantMenu->nama));
        //         foreach ($order->orderAddOn as $key => $oad) {
        //             $printer->text(buatBaris4Kolom($oad->addOn->title, $oad->addOnDetail->nama));
        //             # code...
        //         }
        //         $printer->text("----------------------------------------\n");
                
        //     }
        // }
        $printer->text("----------------------------------------\n");
        // $printer->text(buatBaris4Kolom('', '', "Total", "56.400"));
        $printer->text("\n");

         // Pesan penutup
        $printer->initialize();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih telah berbelanja\n");
        
        $printer->feed(5); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
        $printer->cut();
        $printer->close();
        return 'Success';
    }
}
