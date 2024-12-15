<?php

namespace App\DTOs\Todo;

class UpdateTodoDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?string $status = null,
    ) {
    }

    public static function fromRequest(array $validated): self
    {
        return new self(
            title: $validated['title'] ?? null,
            description: $validated['description'] ?? null,
            status: $validated['status'] ?? null,
        );
    }
}
