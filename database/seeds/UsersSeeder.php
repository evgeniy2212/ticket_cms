<?php

    use App\Models\User;
    use Illuminate\Database\Seeder;
    use App\Models\Role;

    class UsersSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $admin           = new User();
            $admin->name     = 'Admin';
            $admin->password = bcrypt('secret');
            $admin->email    = 'admin@example.com';
            $admin->active   = true;
            $admin->save();

            $role = Role::where('name', User::SUPERADMIN)->first();
            $admin->assignRole($role);

            $admin           = new User();
            $admin->name     = 'Manager';
            $admin->password = bcrypt('secret');
            $admin->email    = 'manager@example.com';
            $admin->active   = true;
            $admin->save();

            $role = Role::where('name', 'Manager')->first();
            $admin->assignRole($role);

        }
    }
