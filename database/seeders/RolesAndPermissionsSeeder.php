<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear Spatie's internal cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Disable foreign key checks to prevent delete constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 3. Clear out the tables completely
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        Role::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Create your latest fresh Roles (Keep these variables!)
        $superAdmin = Role::create(['name' => 'super-admin']);
        $staff      = Role::create(['name' => 'staff']);
        $customer   = Role::create(['name' => 'customer']);

        // 5. Create Permissions
        $permissions = [
            // Staff permissions
            'view-bookings',
            'view-booking-details',
            'view-vehicles',
            'view-vehicle-details',
            'view-drivers',
            'view-driver-details',
            'view-promotions',
            'view-promotion-details',
            'view-deposit-settings',
            'view-notifications',
            'change-car-status',
            'change-driver-status',
            'view-transactions',
            'access-staff-dashboard',

            // Customer permissions
            'create-bookings',
            'request-drivers',
            'view-booking-history',
            'receive-notifications',
            'access-customer-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 6. Assign Permissions using the existing role instances (No Role::create here!)
        
        // Super Admin — all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Staff
        $staff->givePermissionTo([
            'view-bookings',
            'view-booking-details',
            'view-vehicles',
            'view-vehicle-details',
            'view-drivers',
            'view-driver-details',
            'view-promotions',
            'view-promotion-details',
            'view-deposit-settings',
            'view-notifications',
            'change-car-status',
            'change-driver-status',
            'view-transactions',
            'access-staff-dashboard',
        ]);

        // Customer
        $customer->givePermissionTo([
            'create-bookings',
            'request-drivers',
            'view-booking-history',
            'receive-notifications',
            'access-customer-dashboard',
        ]);
    }
}