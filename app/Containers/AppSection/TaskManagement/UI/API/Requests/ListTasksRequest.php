<?php

namespace App\Containers\AppSection\TaskManagement\UI\API\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;
use Illuminate\Validation\Rule;

final class ListTasksRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'filter' => ['nullable', 'string', Rule::in(['all', 'completed', 'pending'])],
        ];
    }
}
