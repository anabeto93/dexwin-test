<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\ListTodoRequest;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Todo API",
 *     version="1.0.0",
 *     description="A simple Todo REST API"
 * )
 */
class TodoController extends Controller
{
    public function __construct(
        private readonly TodoService $todoService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/todos",
     *     summary="List all todos",
     *     tags={"Todos"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search todos by title or details",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter todos by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"completed", "in progress", "not started"})
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort_direction",
     *         in="query",
     *         description="Sort direction",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of todos",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="details", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             ))
     *         )
     *     )
     * )
     */
    public function index(ListTodoRequest $request): JsonResponse
    {
        $result = $this->todoService->list($request->getData());

        return response()->json($result->toArray(), $result->code);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/todos",
     *     summary="Create a new todo",
     *     tags={"Todos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "details", "status"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="details", type="string"),
     *             @OA\Property(property="status", type="string", enum={"completed", "in progress", "not started"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Todo created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="details", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreTodoRequest $request): JsonResponse
    {
        $result = $this->todoService->create($request->getData());

        return response()->json($result->toArray(), $result->code);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/todos/{id}",
     *     summary="Get a specific todo",
     *     tags={"Todos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="details", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     )
     * )
     */
    public function show(string|int $todo): JsonResponse
    {
        $result = $this->todoService->show($todo);

        return response()->json($result->toArray(), $result->code);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/todos/{id}",
     *     summary="Update a todo",
     *     tags={"Todos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="details", type="string"),
     *             @OA\Property(property="status", type="string", enum={"completed", "in progress", "not started"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="details", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateTodoRequest $request, string|int $todo): JsonResponse
    {
        $result = $this->todoService->update($todo, $request->getData());

        return response()->json($result->toArray(), $result->code);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/todos/{id}",
     *     summary="Delete a todo",
     *     tags={"Todos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Todo deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     )
     * )
     */
    public function destroy(string|int $todo): JsonResponse
    {
        $result = $this->todoService->delete($todo);

        return response()->json($result->toArray(), $result->code);
    }
}
