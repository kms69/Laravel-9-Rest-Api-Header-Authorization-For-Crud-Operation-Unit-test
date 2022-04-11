<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CustomerTest extends TestCase
{

    /**
     * Authenticate user.
     *
     * @return string|null
     */
    protected function authenticate(): ?string
    {
        $user = User::create([
            'name' => 'james',
            'email' => rand(12345, 678910) . 'james@gmail.com',
            'password' => bcrypt('secret1234'),

        ]);

        if (!auth()->attempt(['email' => $user->email, 'password' => 'secret1234'])) {
            return null;
        }

        $token = auth()->user()->createToken('API Token')->accessToken;
        return $token;

    }

    /**
     * test create customer.
     *
     * @return void
     */
    public function test_create_customer()
    {
        $token = $this->authenticate();
        $this->assertNotNull($token);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', 'api/customer', [
            'first_name' => 'john',
            'email' => rand(12345, 678910) . 'john@example.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);
    }

    /**
     * test update product.
     *
     * @return void
     */
    public function test_update_customer()
    {
        $token = $this->authenticate();
        $newName = 'robert';
        $newEmail = rand(12345, 678910) .'robert@example.com';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', 'api/customer/1', [
            'first_name' => $newName,
            'email' => $newEmail,
            'password' => '43214455'
        ]);
        $customerNewInfo = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', 'api/customer/1');
        $customerNewInfo = $customerNewInfo->json();
        $this->assertEquals($customerNewInfo['customer']['first_name'], $newName);
        $this->assertEquals($customerNewInfo['customer']['email'], $newEmail);

        $response->assertStatus(200);
    }

    /**
     * test find product.
     *
     * @return void
     */
    public function test_find_customer()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', 'api/customer/1');

        $response->assertStatus(200);
    }

    /**
     * test get all products.
     *
     * @return void
     */
    public function test_get_all_customer()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', 'api/customer');

        $response->assertStatus(200);
    }

    /**
     * test delete products.
     *
     * @return void
     */
    public function test_delete_customer()
    {
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', 'api/customer/2');

        $response->assertStatus(200);
    }
}
