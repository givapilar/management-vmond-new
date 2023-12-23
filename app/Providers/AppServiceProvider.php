<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // $this->app['request']->server->set('HTTPS', true);
        // URL::forceScheme('https');
        
        view()->composer('*', function (){
            // $orderTable = Order::where('user_id', Auth::user()->id)->where('status', 'Paid')->get();
            // $orderPivot = Order::finorFail();
            // $orderTable = Order::get();
            // // $orderTable = OrderPivot::get();
            // // dd($orderPivot);
            // View::share('order_table',$orderTable);
        });
    }
}
