<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Controllers;

use Apiato\Support\Facades\Response;
use App\Containers\AppSection\TaskManagement\Actions\FindTaskAction;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\FindTaskRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Transformers\TaskTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

final class FindTaskController extends ApiController
{
    public function __invoke(FindTaskRequest $request, FindTaskAction $action): JsonResponse
    {
        return Response::create(
            $action->run($request->user('api'), $request->integer('task_id')),
            TaskTransformer::class,
        )->ok();
    }
}
