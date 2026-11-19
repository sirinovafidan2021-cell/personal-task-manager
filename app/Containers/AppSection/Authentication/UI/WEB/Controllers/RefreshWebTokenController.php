<?php

namespace App\Containers\AppSection\Authentication\UI\WEB\Controllers;

use App\Containers\AppSection\Authentication\Actions\Web\LogoutAction;
use App\Containers\AppSection\Authentication\Actions\Web\RefreshWebTokenAction;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\RefreshWebTokenRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RefreshWebTokenController extends WebController
{
    public function __invoke(
        RefreshWebTokenRequest $request,
        RefreshWebTokenAction $refreshWebTokenAction,
        LogoutAction $logoutAction,
    ): JsonResponse {
        try {
            return response()->json($refreshWebTokenAction->run($request->session(), $request->user('web')->getKey()));
        } catch (Throwable) {
            $logoutAction->run($request->session());

            return response()->json(['message' => 'Sessiyanın müddəti bitib. Yenidən daxil olun.'], 401);
        }
    }
}
