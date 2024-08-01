<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'bank-list',
            'bank-create',
            'bank-edit',
            'bank-delete',
            'country-list',
            'country-create',
            'country-edit',
            'country-delete',
            'rate-list',
            'rate-create',
            'rate-edit',
            'rate-delete',
            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-delete',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'client-account-list',
            'client-account-create',
            'client-account-edit',
            'client-account-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
