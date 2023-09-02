<?php

namespace Feature\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testThatAUserCanAuthenticate(): void
    {
        $user = User::factory()->createOne();

        $response = $this->postJson(
            '/api/auth/login',
            [
                'email' => $user->email,
                'password' => UserFactory::DEFAULT_PASSWORD,
            ]
        );

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->hasAll(['message', 'data', 'data.access_token'])
                    ->whereAllType([
                        'message' => 'string',
                        'data' => 'array',
                        'data.access_token' => 'string',
                    ])
                    ->where('message', __('auth.succeeded'))
            );

        $this->assertAuthenticated();
    }

    public function testThatAUserWithWrongPasswordCanNotAuthenticate(): void
    {
        $user = User::factory()->createOne();

        $response = $this->postJson(
            '/api/auth/login',
            [
                'email' => $user->email,
                'password' => Str::password(),
            ]
        );

        $response->assertBadRequest()
            ->assertJson(
                fn (AssertableJson $json) => $json->hasAll(['message', 'description'])
                    ->whereAllType([
                        'message' => 'string',
                        'description' => ['string', 'null'],
                    ])
                    ->where('message', __('auth.failed'))
            );

        self::assertNotTrue($this->isAuthenticated());
    }

    public function testThatANonExistentUserCanNotAuthenticate(): void
    {
        $user = User::factory()->makeOne();

        $response = $this->postJson(
            '/api/auth/login',
            [
                'email' => $user->email,
                'password' => UserFactory::DEFAULT_PASSWORD,
            ]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email'])
            ->assertJson(
                fn (AssertableJson $json) => $json->hasAll(['message', 'errors'])
                    ->whereAllType([
                        'message' => 'string',
                        'errors' => 'array',
                    ])
            );

        self::assertNotTrue($this->isAuthenticated());
    }
}
