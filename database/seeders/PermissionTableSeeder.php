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
            'material-index',
            'material-create',
            'material-edit',
            'material-delete',
            'restaurant-index',
            'restaurant-create',
            'restaurant-edit',
            'restaurant-delete',
            'meeting-room-index',
            'meeting-room-create',
            'meeting-room-edit',
            'meeting-room-delete',
            'biliard-index',
            'biliard-create',
            'biliard-edit',
            'biliard-delete',
            'banner-index',
            'banner-create',
            'banner-edit',
            'banner-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
