<?php

    namespace Tests\Feature\Frontend;

    use App\Models\Client;
    use Tests\TestCase;

    class AuthTest extends TestCase
    {
        public function testNonAuthProfile()
        {
            $this->get(route('profile'))->assertRedirect(route('login'));
        }

        public function testProfile()
        {
            $client = Client::first();
            $this->actingAs($client, 'web')->get(route('profile'))->assertStatus(200);
        }

        public function testLogin()
        {
            $client           = Client::first();
            $client->email    = 'user@example.com';
            $client->password = bcrypt('secret');
            $client->save();

            $this->withoutMiddleware();
            $this->post(route('login'), [
                'email'    => 'user@example.com',
                'password' => 'secret',
            ]);
            $this->assertAuthenticatedAs($client, 'web');
        }

        public function testLogout()
        {
            $this->withoutMiddleware();
            $this->post(route('login'), [
                'email'    => 'user@example.com',
                'password' => 'secret',
            ]);

            $this->get(route('logout'));
            $this->get(route('home'))->assertOk();
        }

    }
