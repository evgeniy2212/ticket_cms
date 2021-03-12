<?php

    namespace Tests\Feature\Backend;

    use App\Models\User;
    use Tests\TestCase;

    class BasicTest extends TestCase
    {
        /**
         * A basic test example.
         *
         * @return void
         */
        public function testBasicTest()
        {
            $this->get(route('backend.home'))->assertOk();
            $this->get(route('backend.login'))->assertOk();
            $this->withoutMiddleware()->actingAs(User::first())->get(route('backend.dashboard'))->assertStatus(200);
            $this->withoutMiddleware()->actingAs(User::first())->get(route('backend.users.index'))->assertStatus(200);
            $this->withoutMiddleware()->actingAs(User::first())->get(route('backend.roles.index'))->assertStatus(200);
            $this->withoutMiddleware()->actingAs(User::first())->get(route('backend.permissions.index'))->assertStatus(200);
            $this->withoutMiddleware()->actingAs(User::first())->get(route('backend.clients.index'))->assertStatus(200);
            $this->withoutMiddleware()->actingAs(User::first())->get(route('backend.pages.index'))->assertStatus(200);
        }
    }
