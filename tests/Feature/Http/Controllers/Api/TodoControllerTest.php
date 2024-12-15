<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_todos(): void
    {
        Todo::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/todos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => ['id', 'title', 'details', 'status', 'created_at', 'updated_at']
                    ],
                    'current_page',
                    'total'
                ]
            ]);
    }

    public function test_can_create_todo(): void
    {
        $todoData = [
            'title' => 'Test Todo',
            'details' => 'Test Details',
            'status' => 'not started'
        ];

        $response = $this->postJson('/api/v1/todos', $todoData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'title', 'details', 'status', 'created_at', 'updated_at']
            ]);

        $this->assertDatabaseHas('todos', $todoData);
    }

    public function test_can_update_todo(): void
    {
        $todo = Todo::factory()->create();
        $updateData = [
            'title' => 'Updated Title',
            'status' => 'completed'
        ];

        $response = $this->patchJson("/api/v1/todos/{$todo->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Title',
            'status' => 'completed'
        ]);
    }

    public function test_can_delete_todo(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->deleteJson("/api/v1/todos/{$todo->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('todos', ['id' => $todo->id]);
    }

    public function test_can_filter_todos_by_status(): void
    {
        Todo::factory()->count(3)->create(['status' => 'completed']);
        Todo::factory()->count(2)->create(['status' => 'in progress']);

        $response = $this->getJson('/api/v1/todos?status=completed');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data.data')
            ->assertJsonFragment(['status' => 'completed']);
    }

    public function test_can_search_todos(): void
    {
        Todo::factory()->create(['title' => 'Find this todo']);
        Todo::factory()->create(['title' => 'Another todo']);

        $response = $this->getJson('/api/v1/todos?search=Find');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonFragment(['title' => 'Find this todo']);
    }

    public function test_validates_required_fields_when_creating(): void
    {
        $response = $this->postJson('/api/v1/todos', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'details', 'status']);
    }

    public function test_validates_status_values(): void
    {
        $response = $this->postJson('/api/v1/todos', [
            'title' => 'Test',
            'details' => 'Test details',
            'status' => 'invalid-status'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
