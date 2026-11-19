<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Controllers;

use Apiato\Support\Facades\Response;
use App\Containers\AppSection\TaskManagement\Actions\ListTasksAction;
use App\Containers\AppSection\TaskManagement\UI\API\Requests\ListTasksRequest;
use App\Containers\AppSection\TaskManagement\UI\API\Transformers\TaskTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

final class ListTasksController extends ApiController
{
    public function __invoke(ListTasksRequest $request, ListTasksAction $action): JsonResponse
    {
        return Response::create(
            $action->run($request->user('api'), $request->string('filter', 'all')->toString()),
            TaskTransformer::class,
        )->ok();
    }
}
