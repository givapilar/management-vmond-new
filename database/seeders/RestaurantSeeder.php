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
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Ayam Goreng';
        $user->category = 'Makanan';
        $user->harga = '18.000,00';
        $user->status = 'Tersedia';
        $user->description = 'Ayam goreng (bahasa Inggris: fried chicken), atau ayam goreng tepung adalah hidangan yang dibuat dari potongan daging ayam yang';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Croffle';
        $user->category = 'Makanan';
        $user->harga = '18.000,00';
        $user->status = 'Tersedia';
        $user->description = 'The croffle has been the trendy breakfast and brunch pastry for some years now! But what is it? If you haven’t noticed it by its name,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Sandwiches';
        $user->category = 'Makanan';
        $user->harga = '15.000,00';
        $user->status = 'Tersedia';
        $user->description = 'Roti yang diisi dengan berbagai macam bahan seperti daging ayam panggang, ham, keju, salad tuna, daging sapi panggang, dan sebagainya.';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Coffee Espresso';
        $user->category = 'Minuman';
        $user->harga = '20.000,00';
        $user->status = 'Tersedia';
        $user->description = 'Espresso adalah minuman kopi yang dibuat dengan menyeduh biji kopi yang telah digiling halus dan dikompres dalam mesin espresso dengan tekanan tinggi dan air panas.';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Restaurant();
        $user->nama = 'Lychee tea';
        $user->category = 'Minuman';
        $user->harga = '25.000,00';
        $user->status = 'Tersedia';
        $user->description = 'Lychee tea merupakan minuman teh yang diberi aroma buah lici (lychee) dan kadang-kadang diberi tambahan gula untuk memberikan rasa manis yang lezat.';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();
    }
}
