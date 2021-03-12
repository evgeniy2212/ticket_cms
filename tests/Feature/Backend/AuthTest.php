<?php

    namespace Tests\Feature\Backend;

    use App\Models\User;
    use Tests\TestCase;

    class AuthTest extends TestCase
    {
        public function testLogin()
        {
            $client           = User::first();
            $client->email    = 'admin@example.com';
            $client->password = bcrypt('secret');
            $client->save();

            $this->withoutMiddleware();
            $this->post(route('backend.login'), [
                'email'    => 'admin@example.com',
                'password' => 'secret',
            ]);
            $this->assertAuthenticatedAs($client, 'admin');
        }

        public function testLogout()
        {
            $this->withoutMiddleware();
            $this->post(route('backend.login'), [
                'email'    => 'admin@example.com',
                'password' => 'secret',
            ]);

            $this->get(route('backend.logout'));
            $this->get(route('home'))->assertOk();
        }

    }
