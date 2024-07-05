<?php

namespace App\Http\Requests\TaskRequest;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable', 'string', 'sometimes'],
            'status' => ['required', 'integer', Rule::enum(TaskStatus::class)],
            'expected_at' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
