<?php

namespace App\Containers\AppSection\Authentication\Actions\Web;

use App\Containers\AppSection\Authentication\Actions\Api\WebClient\IssueTokenAction;
use App\Containers\AppSection\Authentication\Tasks\WebTokenSessionTask;
use App\Containers\AppSection\Authentication\Values\UserCredential;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

final class LoginAction extends ParentAction
{
    public function __construct(
        private readonly IssueTokenAction $issueTokenAction,
        private readonly WebTokenSessionTask $webTokenSessionTask,
    ) {
    }

    public function run(string $email, string $password, bool $remember): RedirectResponse
    {
        $credentials = [
            'email' => static fn (Builder $query): Builder => $query
                ->orWhereRaw('lower(email) = lower(?)', [$email]),
            'password' => $password,
        ];

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $session = session()->driver();
            $session->regenerate();

            try {
                $this->webTokenSessionTask->store(
                    $session,
                    $this->issueTokenAction->run(UserCredential::create($email, $password)),
                );
            } catch (Throwable) {
                Auth::guard('web')->logout();
                $session->invalidate();
                $session->regenerateToken();

                return back()->withErrors([
                    'email' => 'Daxil olma hazırda mümkün deyil. Zəhmət olmasa yenidən cəhd edin.',
                ])->onlyInput('email');
            }

            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }
}
