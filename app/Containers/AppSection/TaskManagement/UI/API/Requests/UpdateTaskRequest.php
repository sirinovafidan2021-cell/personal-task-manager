<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Requests;

use App\Containers\AppSection\TaskManagement\UI\API\Requests\Concerns\ResolvesTaskRouteId;
use App\Ship\Parents\Requests\Request as ParentRequest;
use Illuminate\Validation\Validator;

final class UpdateTaskRequest extends ParentRequest
{
    use ResolvesTaskRouteId;
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'integer'],
            'title' => ['sometimes', 'required', 'string', 'max:150'],
            'description' => ['sometimes', 'nullable', 'string'],
            'is_completed' => ['sometimes', 'boolean'],
            'user_id' => ['prohibited'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['task_id' => $this->taskRouteId()]);
    }

    /** @return array<int, \Closure(Validator): void> */
    public function after(): array
    {
        return [function (Validator $validator): void {
            if (!$this->hasAny(['title', 'description', 'is_completed', 'user_id'])) {
                $validator->errors()->add('payload', 'Ən azı bir yenilənə bilən sahə göndərilməlidir.');
            }
        }];
    }
}
