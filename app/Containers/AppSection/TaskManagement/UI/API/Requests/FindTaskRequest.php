<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Requests;

use App\Containers\AppSection\TaskManagement\UI\API\Requests\Concerns\ResolvesTaskRouteId;
use App\Ship\Parents\Requests\Request as ParentRequest;

final class FindTaskRequest extends ParentRequest
{
    use ResolvesTaskRouteId;
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['task_id' => $this->taskRouteId()]);
    }
}
