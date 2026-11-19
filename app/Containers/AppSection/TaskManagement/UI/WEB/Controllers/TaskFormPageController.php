<?php

namespace App\Containers\AppSection\TaskManagement\UI\WEB\Controllers;

use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class TaskFormPageController extends WebController
{
    public function create(Request $request): View
    {
        return $this->view($request);
    }

    public function edit(Request $request, string $task_id): View
    {
        return $this->view($request, $task_id);
    }

    private function view(Request $request, ?string $taskId = null): View
    {
        return view('appSection@taskManagement::tasks.form', [
            'accessToken' => $request->session()->get('task_manager.access_token'),
            'apiBaseUrl' => url('/v1/tasks'),
            'taskId' => $taskId,
        ]);
    }
}
