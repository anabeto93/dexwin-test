<?php

namespace App\DTOs;

class ApiResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly int $code,
        public readonly array $data,
    ) {
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
        ];
    }
}
