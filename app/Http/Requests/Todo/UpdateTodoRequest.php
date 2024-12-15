<?php

namespace App\Http\Requests\Todo;

use App\DTOs\Todo\UpdateTodoDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'details' => ['sometimes', 'required', 'string'],
            'status' => ['sometimes', 'required', Rule::in(['completed', 'in progress', 'not started'])],
        ];
    }

    public function getData(): UpdateTodoDTO
    {
        $validated = $this->validated();
        return new UpdateTodoDTO(
            title: $validated['title'] ?? null,
            description: $validated['details'] ?? null, // Map details to description
            status: $validated['status'] ?? null
        );
    }
}
