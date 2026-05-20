<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // সব পারমিশন তৈরি করুন
        $permissions = [
            'dashboard.view',
            'machines.view', 'machines.create', 'machines.edit', 'machines.delete',
            'breakdowns.report', 'breakdowns.view', 'breakdowns.edit',
            'services.schedule', 'services.complete', 'services.overdue.view',
            'reports.view', 'reports.export',
            'users.manage', 'roles.manage',
            'planning.view', 'planning.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // রোল তৈরি + পারমিশন অ্যাসাইন
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $groupAdmin = Role::firstOrCreate(['name' => 'Group Admin']);
        $groupAdmin->givePermissionTo(['dashboard.view', 'machines.view', 'breakdowns.view', 'services.overdue.view', 'reports.view', 'reports.export', 'users.manage']);

        $factoryManager = Role::firstOrCreate(['name' => 'Factory Manager']);
        $factoryManager->givePermissionTo(['dashboard.view', 'machines.view', 'breakdowns.view', 'services.schedule', 'services.complete', 'reports.view']);

        $maintenanceSupervisor = Role::firstOrCreate(['name' => 'Maintenance Supervisor']);
        $maintenanceSupervisor->givePermissionTo(['breakdowns.view', 'breakdowns.edit', 'services.schedule', 'services.complete', 'services.overdue.view']);

        $mechanic = Role::firstOrCreate(['name' => 'Mechanic']);
        $mechanic->givePermissionTo(['breakdowns.report', 'breakdowns.view', 'services.complete']);

        $operator = Role::firstOrCreate(['name' => 'Operator']);
        $operator->givePermissionTo(['breakdowns.report']);

        $viewer = Role::firstOrCreate(['name' => 'Viewer']);
        $viewer->givePermissionTo(['dashboard.view', 'reports.view']);
    }
}