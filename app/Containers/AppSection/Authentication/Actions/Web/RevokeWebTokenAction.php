<?php

namespace App\Containers\AppSection\Authentication\Actions\Web;

use App\Containers\AppSection\Authentication\Tasks\WebTokenSessionTask;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Contracts\Session\Session;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

final class RevokeWebTokenAction extends ParentAction
{
    public function __construct(private readonly WebTokenSessionTask $webTokenSessionTask)
    {
    }

    public function run(Session $session): void
    {
        $accessTokenId = $this->webTokenSessionTask->accessTokenId($session);
        if ($accessTokenId !== null) {
            Token::query()->whereKey($accessTokenId)->update(['revoked' => true]);
            RefreshToken::query()->where('access_token_id', $accessTokenId)->update(['revoked' => true]);
        }

        $this->webTokenSessionTask->forget($session);
    }
}
