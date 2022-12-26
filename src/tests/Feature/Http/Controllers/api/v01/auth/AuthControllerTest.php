<?php

namespace Tests\Feature\Http\Controllers\api\v01\auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    /**
     * register
     */
    public function test_should_be_validate_register()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }
    public function test_new_user_create_register()
    {
        $response = $this->postJson(route('auth.register'),[
            'name' => 'mohammad nikeash',
            'email' => fake()->email(),
            'password' => 123456,
            'password_confirmation' => 123456
        ]);
        $response->assertStatus(201);
    }
    /**
     * login
     */
    public function test_should_be_validate_user(){
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(422);
    }
    public function test_user_can_login_with_true_credntials(){
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'),[
            'email' => $user->email,
            'password' => $user->password
        ]);
        $response->assertStatus(200);
    }
    /**
     * logout
     */
    public function test_logged_in_user_can_logout(){
        $user = User::factory()->create();
        $user = Auth::loginUsingId($user->id);
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }

}
