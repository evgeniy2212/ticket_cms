<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                RolesSeeder::class,
                UsersSeeder::class,
                ThemeSeeder::class,
                SiteSeeder::class,
                ClientsSeeder::class,
                FieldTypesSeeder::class,
            ]
        );
    }
}
