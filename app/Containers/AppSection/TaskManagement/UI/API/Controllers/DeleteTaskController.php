<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Controllers;

use App\Containers\AppSection\TaskManagement\Actions\DeleteTaskAction;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\DeleteTaskRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\Response;

final class DeleteTaskController extends ApiController
{
    public function __invoke(DeleteTaskRequest $request, DeleteTaskAction $action): Response
    {
        $action->run($request->user('api'), $request->integer('task_id'));

        return response()->noContent();
    }
}
