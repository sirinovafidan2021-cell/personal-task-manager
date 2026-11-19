<?php

namespace App\Containers\AppSection\Authentication\UI\WEB\Controllers;

use App\Containers\AppSection\Authentication\Actions\RegisterUserAction;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\RegisterRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class RegisterController extends WebController
{
    public function showForm(): View
    {
        return view('appSection@authentication::register');
    }

    public function __invoke(RegisterRequest $request, RegisterUserAction $action): RedirectResponse
    {
        $action->transactionalRun($request->safe()->only(['name', 'email', 'password']));

        return redirect()->route('login.form')->with('status', 'Qeydiyyat uğurla tamamlandı. İndi daxil olun.');
    }
}
