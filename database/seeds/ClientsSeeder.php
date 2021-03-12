<?php

use App\Models\Client;
use Illuminate\Database\Seeder;
use App\Models\Site;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client             = new Client();
        $client->first_name = 'Test';
        $client->last_name  = 'Testov';
        $client->password   = bcrypt('secret');
        $client->email      = 'user@example.com';
        $client->site_id    = Site::all()->first()->id;
        $client->active     = true;
        $client->save();
    }
}
