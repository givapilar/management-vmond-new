<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'dashboard',
            'master-data',
            'toko-online',
            'inventory',
            'permit-admin',
            'report-penjualan',
            'departement-list',
            'departement-create',
            'departement-edit',
            'departement-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'history-log-list',
            'history-log-delete',
            'bahan-baku-list',
            'bahan-baku-create',
            'bahan-baku-edit',
            'bahan-baku-delete',
            'membership-list',
            'membership-create',
            'membership-edit',
            'membership-delete',
            'restaurant-list',
            'restaurant-create',
            'restaurant-edit',
            'restaurant-delete',
            'asset-management-list',
            'asset-management-create',
            'asset-management-edit',
            'asset-management-delete',
            'tag-list',
            'tag-create',
            'tag-edit',
            'tag-delete',
            'meeting-room-list',
            'meeting-room-create',
            'meeting-room-edit',
            'meeting-room-delete',
            'biliard-list',
            'biliard-create',
            'biliard-edit',
            'biliard-delete',
            'media-advertising-list',
            'media-advertising-create',
            'media-advertising-edit',
            'media-advertising-delete',
            'stok-masuk-list',
            'stok-masuk-create',
            'stok-masuk-edit',
            'stok-masuk-delete',
            'stok-keluar-list',
            'stok-keluar-create',
            'stok-keluar-edit',
            'stok-keluar-delete',
            'meja-restaurant-list',
            'meja-restaurant-create',
            'meja-restaurant-edit',
            'meja-restaurant-delete',
            'paket-menu-list',
            'paket-menu-create',
            'paket-menu-edit',
            'paket-menu-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
