<?php

namespace Database\Seeders;

use App\Enums\AddressPermissionsEnum;
use App\Enums\ClientPermissionsEnum;
use App\Enums\ProjectPermissionsEnum;
use App\Enums\RolesEnum;
use App\Enums\TaskPermissionsEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        foreach (ProjectPermissionsEnum::toArray() as $permission) {
            app(Permission::class)->findOrCreate($permission, 'web');
        }

        foreach (ClientPermissionsEnum::toArray() as $permission) {
            app(Permission::class)->findOrCreate($permission, 'web');
        }

        foreach (AddressPermissionsEnum::toArray() as $permission) {
            app(Permission::class)->findOrCreate($permission, 'web');
        }

        foreach (TaskPermissionsEnum::toArray() as $permission) {
            app(Permission::class)->findOrCreate($permission, 'web');
        }

        // create roles and assign created permissions

        $administrator = app(Role::class)->findOrCreate(RolesEnum::ADMINISTRATOR->value, 'web');
        $administrator->givePermissionTo(Permission::all());

        $salesRepresentative = app(Role::class)->findOrCreate(RolesEnum::SALES->value, 'web');
        $salesRepresentative->givePermissionTo(ProjectPermissionsEnum::toArray());
        $salesRepresentative->givePermissionTo(TaskPermissionsEnum::toArray());
        $salesRepresentative->givePermissionTo(ClientPermissionsEnum::toArray());
        $salesRepresentative->givePermissionTo(AddressPermissionsEnum::toArray());

        $customerSupport = app(Role::class)->findOrCreate(RolesEnum::SUPPORT->value, 'web');
        $customerSupport->givePermissionTo(ProjectPermissionsEnum::READ_PROJECTS);
        $customerSupport->givePermissionTo(TaskPermissionsEnum::READ_TASKS);

        $marketingProfessional = app(Role::class)->findOrCreate(RolesEnum::MARKETING->value, 'web');
        $marketingProfessional->givePermissionTo(ClientPermissionsEnum::READ_CLIENTS);

        $analyst = app(Role::class)->findOrCreate(RolesEnum::ANALYST->value, 'web');
        $analyst->givePermissionTo(ProjectPermissionsEnum::READ_PROJECTS);
        $analyst->givePermissionTo(TaskPermissionsEnum::READ_TASKS);
        $analyst->givePermissionTo(ClientPermissionsEnum::READ_CLIENTS);
        $analyst->givePermissionTo(AddressPermissionsEnum::READ_ADDRESSES);
    }
}
