<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_return_token_after_login()
    {
        $this->withoutExceptionHandling();
        /** @var User $user */
        $user = factory(User::class)->create([
            'password' => Hash::make('password')
        ]);
        
        $response = $this->post(route('api.v1.auth.login'),[
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'MyDevice',
        ]);

        
        $response->assertCreated();
        $response->assertJsonStructure(['plain_text_token']);
        $this->assertTrue(
            !is_null(
                PersonalAccessToken::findToken($response['plain_text_token'])
            )
        );
    }
}
