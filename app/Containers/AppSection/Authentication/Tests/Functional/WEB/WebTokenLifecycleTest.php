<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\WEB;

use App\Containers\AppSection\Authentication\Data\Factories\ClientFactory;
use App\Containers\AppSection\Authentication\Tests\Functional\WebTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LoginController;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LogoutController;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\RefreshWebTokenController;
use App\Containers\AppSection\TaskManagement\UI\API\Controllers\ListTasksController;
use App\Containers\AppSection\User\Models\User;
use Laravel\Passport\Token;

final class WebTokenLifecycleTest extends WebTestCase
{
    public function testWebSessionIssuesRefreshesAndRevokesOnlyItsPassportToken(): void
    {
        $user = User::factory()->createOne(['password' => 'correct-password']);
        ClientFactory::webClient();

        $this->post(action(LoginController::class), [
            'email' => $user->email,
            'password' => 'correct-password',
        ])->assertRedirect();

        $accessToken = session('task_manager.access_token');
        $accessTokenId = session('task_manager.access_token_id');
        $this->assertIsString($accessToken);
        $this->assertIsString($accessTokenId);
        $this->withToken($accessToken)->getJson(action(ListTasksController::class))->assertOk();

        $refresh = $this->postJson(action(RefreshWebTokenController::class));
        $refresh->assertOk()
            ->assertJsonStructure(['access_token', 'expires_at'])
            ->assertJsonMissing(['refresh_token', 'client_secret']);
        $this->assertNotSame($accessToken, $refresh->json('access_token'));

        $freshAccessToken = session('task_manager.access_token');
        $freshAccessTokenId = session('task_manager.access_token_id');
        $this->post(action(LogoutController::class))->assertRedirect();

        $this->assertTrue(Token::query()->findOrFail($freshAccessTokenId)->revoked);
        app('auth')->forgetGuards();
        $this->withToken($freshAccessToken)->getJson(action(ListTasksController::class))->assertUnauthorized();
        $this->assertTrue(Token::query()->findOrFail($accessTokenId)->revoked);
    }
}
