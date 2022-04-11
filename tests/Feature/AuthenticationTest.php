<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testRegister()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'Test',
            'email' => time() . 'test@example.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',

        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response);

    }

    public function testLogin()
    {
        User::create([
            'name' => 'Test',
            'email' => $email = time() . '@example.com',
            'password' => $password = bcrypt('123456789'),

        ]);

        $response = $this->json('POST', route('login'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200);


    }

}
