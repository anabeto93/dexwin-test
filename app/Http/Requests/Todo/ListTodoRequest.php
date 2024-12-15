<?php

namespace App\Http\Requests\Todo;

use App\DTOs\Todo\ListTodoDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'search' => $this->query('search'),
            'status' => $this->query('status'),
            'sort_by' => $this->query('sort_by', 'created_at'),
            'sort_direction' => $this->query('sort_direction', 'desc'),
            'per_page' => $this->query('per_page', 10),
        ]);
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(['completed', 'in progress', 'not started'])],
            'sort_by' => ['nullable', Rule::in(['title', 'created_at', 'status'])],
            'sort_direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function getData(): ListTodoDTO
    {
        return ListTodoDTO::fromRequest($this->validated());
    }
}
