<?php

    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Database\Seeder;
    use App\Models\Permission;
    use Illuminate\Support\Facades\DB;
    use Spatie\Permission\PermissionRegistrar;

    class RolesSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            // Reset cached roles and permissions
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            // create permissions
            DB::transaction(function () {
                //clients
                Permission::create(['name' => 'add clients']);
                Permission::create(['name' => 'edit clients']);
                Permission::create(['name' => 'delete clients']);
                Permission::create(['name' => 'list clients']);

                //users
                Permission::create(['name' => 'add admins']);
                Permission::create(['name' => 'edit admins']);
                Permission::create(['name' => 'delete admins']);
                Permission::create(['name' => 'list admins']);

                //permissions
                Permission::create(['name' => 'add permissions']);
                Permission::create(['name' => 'edit permissions']);
                Permission::create(['name' => 'delete permissions']);
                Permission::create(['name' => 'list permissions']);

                //roles
                Permission::create(['name' => 'add roles']);
                Permission::create(['name' => 'edit roles']);
                Permission::create(['name' => 'delete roles']);
                Permission::create(['name' => 'list roles']);

                // settings
                Permission::create(['name' => 'list settings']);
                Permission::create(['name' => 'edit settings']);
                Permission::create(['name' => 'delete settings']);
                Permission::create(['name' => 'add settings']);

                //pages
                Permission::create(['name' => 'add pages']);
                Permission::create(['name' => 'edit pages']);
                Permission::create(['name' => 'delete pages']);
                Permission::create(['name' => 'list pages']);

                // Emails Module
                Permission::create(['name' => 'add emails']);
                Permission::create(['name' => 'edit emails']);
                Permission::create(['name' => 'delete emails']);
                Permission::create(['name' => 'list emails']);

            });

            $role = Role::create(['name' => User::SUPERADMIN, 'active' => true]);
            $role->syncPermissions(Permission::all());

            $role = Role::create(['name' => 'Manager', 'active' => true]);
            $role->syncPermissions(Permission::whereIn('name', ['add pages', 'edit pages', 'delete pages', 'list pages'])->get());

        }
    }
