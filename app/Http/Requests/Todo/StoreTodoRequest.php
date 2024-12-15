<?php

namespace App\Http\Requests\Todo;

use App\DTOs\Todo\StoreTodoDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string'],
            'status' => ['required', Rule::in(['completed', 'in progress', 'not started'])],
        ];
    }

    public function getData(): StoreTodoDTO
    {
        $validated = $this->validated();
        return new StoreTodoDTO(
            title: $validated['title'],
            description: $validated['details'], // Map details to description
            status: $validated['status']
        );
    }
}
