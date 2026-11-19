<?php

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Data\DTOs\PasswordToken;
use App\Containers\AppSection\Authentication\Data\Factories\TokenAttributeFormatter;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Contracts\Session\Session;

final class WebTokenSessionTask extends ParentTask
{
    private const ACCESS_TOKEN = 'task_manager.access_token';
    private const REFRESH_TOKEN = 'task_manager.refresh_token';
    private const EXPIRES_AT = 'task_manager.token_expires_at';
    private const ACCESS_TOKEN_ID = 'task_manager.access_token_id';

    public function __construct(private readonly TokenAttributeFormatter $tokenAttributeFormatter)
    {
    }

    public function store(Session $session, PasswordToken $token): void
    {
        $attributes = $this->tokenAttributeFormatter->format($token->accessToken);

        $session->put([
            self::ACCESS_TOKEN => $token->accessToken,
            self::REFRESH_TOKEN => $token->refreshToken->value(),
            self::EXPIRES_AT => now()->addSeconds($token->expiresIn)->toIso8601String(),
            self::ACCESS_TOKEN_ID => $attributes['oauth_access_token_id'],
        ]);
    }

    public function accessToken(Session $session): ?string
    {
        return $session->get(self::ACCESS_TOKEN);
    }

    public function refreshToken(Session $session): ?string
    {
        return $session->get(self::REFRESH_TOKEN);
    }

    public function accessTokenId(Session $session): ?string
    {
        return $session->get(self::ACCESS_TOKEN_ID);
    }

    public function expiresAt(Session $session): ?string
    {
        return $session->get(self::EXPIRES_AT);
    }

    public function forget(Session $session): void
    {
        $session->forget([self::ACCESS_TOKEN, self::REFRESH_TOKEN, self::EXPIRES_AT, self::ACCESS_TOKEN_ID]);
    }
}
