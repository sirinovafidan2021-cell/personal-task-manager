<?php

namespace App\Containers\AppSection\Authentication\Actions\Web;

use App\Containers\AppSection\Authentication\Actions\Api\WebClient\RefreshTokenAction;
use App\Containers\AppSection\Authentication\Tasks\WebTokenSessionTask;
use App\Containers\AppSection\Authentication\Values\RefreshToken;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

final class RefreshWebTokenAction extends ParentAction
{
    public function __construct(
        private readonly RefreshTokenAction $refreshTokenAction,
        private readonly WebTokenSessionTask $webTokenSessionTask,
    ) {
    }

    /** @return array{access_token: string, expires_at: string} */
    public function run(Session $session, int $userId): array
    {
        $refreshToken = $this->webTokenSessionTask->refreshToken($session);
        if ($refreshToken === null) {
            throw new RuntimeException('No refresh token is present in the session.');
        }

        return Cache::lock('task-manager:refresh:' . $userId, 10)->block(5, function () use ($session, $refreshToken): array {
            $token = $this->refreshTokenAction->run(RefreshToken::create($refreshToken));
            $this->webTokenSessionTask->store($session, $token);

            return [
                'access_token' => $token->accessToken,
                'expires_at' => $this->webTokenSessionTask->expiresAt($session),
            ];
        });
    }
}
