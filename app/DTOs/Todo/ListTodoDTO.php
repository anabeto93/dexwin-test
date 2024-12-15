<?php

namespace App\DTOs\Todo;

class ListTodoDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $status = null,
        public readonly string $sortBy = 'created_at',
        public readonly string $sortDirection = 'desc',
        public readonly int $perPage = 10,
    ) {
    }

    public static function fromRequest(array $validated): self
    {
        return new self(
            search: $validated['search'] ?? null,
            status: $validated['status'] ?? null,
            sortBy: $validated['sort_by'] ?? 'created_at',
            sortDirection: $validated['sort_direction'] ?? 'desc',
            perPage: $validated['per_page'] ?? 10,
        );
    }
}
