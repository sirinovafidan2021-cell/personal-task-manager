<?php

namespace App\Containers\AppSection\Authentication\Actions\Web;

use App\Containers\AppSection\Authentication\Actions\Web\RevokeWebTokenAction;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

final class LogoutAction extends ParentAction
{
    public function __construct(private readonly RevokeWebTokenAction $revokeWebTokenAction)
    {
    }

    public function run(Session $session): void
    {
        $this->revokeWebTokenAction->run($session);
        Auth::guard('web')->logout();

        $session->invalidate();

        $session->regenerateToken();
    }
}
