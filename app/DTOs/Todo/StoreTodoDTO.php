<?php

namespace App\DTOs\Todo;

class StoreTodoDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $status = 'not started',
    ) {
    }

    public static function fromRequest(array $validated): self
    {
        return new self(
            title: $validated['title'],
            description: $validated['description'],
            status: $validated['status'] ?? 'not started',
        );
    }
}
