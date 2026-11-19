<?php

namespace App\Containers\AppSection\TaskManagement\UI\WEB\Controllers;

use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class TasksPageController extends WebController
{
    public function __invoke(Request $request): View
    {
        return view('appSection@taskManagement::tasks.index', [
            'accessToken' => $request->session()->get('task_manager.access_token'),
            'apiBaseUrl' => url('/v1/tasks'),
        ]);
    }
}
