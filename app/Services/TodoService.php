<?php

namespace App\Services;

use App\DTOs\ApiResponse;
use App\DTOs\Todo\ListTodoDTO;
use App\DTOs\Todo\StoreTodoDTO;
use App\DTOs\Todo\UpdateTodoDTO;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;

class TodoService
{
    public function __construct(private Todo $todo)
    {
    }

    public function list(ListTodoDTO $filters): ApiResponse
    {
        $query = $this->todo->query();

        if ($filters->search) {
            $query->where(function (Builder $query) use ($filters) {
                $query->where('title', 'like', "%{$filters->search}%")
                    ->orWhere('details', 'like', "%{$filters->search}%");
            });
        }

        if ($filters->status) {
            $query->where('status', $filters->status);
        }

        $query->orderBy($filters->sortBy, $filters->sortDirection);
        $paginator = $query->paginate($filters->perPage);

        // Transform each model to array to ensure all attributes are visible
        $items = $paginator->items();
        $data = array_map(function ($item) {
            return $item->toArray();
        }, $items);

        return new ApiResponse(
            success: true,
            code: Response::HTTP_OK,
            data: [
                'data' => $data,
                'current_page' => $paginator->currentPage(),
                'total' => $paginator->total(),
            ]
        );
    }

    public function create(StoreTodoDTO $data): ApiResponse
    {
        $todo = $this->todo->create([
            'title' => $data->title,
            'details' => $data->description,
            'status' => $data->status,
        ]);

        return new ApiResponse(
            success: true,
            code: Response::HTTP_CREATED,
            data: $todo->toArray(),
        );
    }

    public function show(int|string $id): ApiResponse
    {
        $todo = $this->todo->find($id);

        if (!$todo) {
            return new ApiResponse(
                success: false,
                code: Response::HTTP_NOT_FOUND,
                data: ['message' => 'Todo not found']
            );
        }

        return new ApiResponse(
            success: true,
            code: Response::HTTP_OK,
            data: $todo->toArray(),
        );
    }

    public function update(int|string $id, UpdateTodoDTO $data): ApiResponse
    {
        $todo = $this->todo->find($id);

        if (!$todo) {
            return new ApiResponse(
                success: false,
                code: Response::HTTP_NOT_FOUND,
                data: ['message' => 'Todo not found']
            );
        }

        $updateData = array_filter([
            'title' => $data->title,
            'details' => $data->description,
            'status' => $data->status,
        ], fn ($value) => !is_null($value));

        $todo->update($updateData);
        
        return new ApiResponse(
            success: true,
            code: Response::HTTP_OK,
            data: $todo->fresh()->toArray(),
        );
    }

    public function delete(int|string $id): ApiResponse
    {
        $todo = $this->todo->find($id);

        if (!$todo) {
            return new ApiResponse(
                success: false,
                code: Response::HTTP_NOT_FOUND,
                data: ['message' => 'Todo not found']
            );
        }

        $todo->delete();
        
        return new ApiResponse(
            success: true,
            code: Response::HTTP_NO_CONTENT,
            data: []
        );
    }
}
