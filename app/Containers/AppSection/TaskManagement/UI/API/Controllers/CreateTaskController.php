<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Controllers;

use Apiato\Support\Facades\Response;
use App\Containers\AppSection\TaskManagement\Actions\CreateTaskAction;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\CreateTaskRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Transformers\TaskTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

final class CreateTaskController extends ApiController
{
    public function __invoke(CreateTaskRequest $request, CreateTaskAction $action): JsonResponse
    {
        return Response::create(
            $action->run($request->user('api'), $request->safe()->only(['title', 'description', 'is_completed'])),
            TaskTransformer::class,
        )->created();
    }
}
