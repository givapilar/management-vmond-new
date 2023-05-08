<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Restaurant();
        $user->nama = 'Nasi Goreng';
        $user->category = 'Makanan';
        $user->harga = '22.000,00';
        $user->status = 'Tersedia';
        $user->description = 'Keripik Singkong Mercon adalah keripik dengan citarasa super pedas yang terbuat dari singkong. Keripik ini cocok buat kamu yang doyan dengan cemilan pedas. Tak hanya pedas, keripik ini ada dalam dua varian rasa, rasa gurih dan rasa manis.';

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Ayam Goreng';
        $user->category = 'Makanan';
        $user->harga = '18.000,00';
        $user->status = 'Tersedia';
        $user->description = 'Ayam goreng (bahasa Inggris: fried chicken), atau ayam goreng tepung adalah hidangan yang dibuat dari potongan daging ayam yang';

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Croffle';
        $user->category = 'Makanan';
        $user->harga = '18.000,00';
        $user->status = 'Tersedia';
        $user->description = 'The croffle has been the trendy breakfast and brunch pastry for some years now! But what is it? If you haven’t noticed it by its name,';

        $user->save();
    }
}
