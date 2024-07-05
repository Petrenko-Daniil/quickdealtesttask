<?php

namespace App\Http\Requests\TaskRequest;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes'],
            'description' => ['nullable', 'string', 'sometimes'],
            'status' => ['sometimes', 'integer', Rule::enum(TaskStatus::class)],
            'expected_at' => ['sometimes', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
