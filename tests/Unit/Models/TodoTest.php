<?php

namespace Tests\Unit\Models;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_can_be_created_with_valid_data(): void
    {
        $todoData = [
            'title' => 'Test Todo',
            'details' => 'Test Details',
            'status' => 'not started'
        ];

        $todo = Todo::create($todoData);

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertEquals($todoData['title'], $todo->title);
        $this->assertEquals($todoData['details'], $todo->details);
        $this->assertEquals($todoData['status'], $todo->status);
    }

    public function test_todo_has_default_status(): void
    {
        $todo = Todo::create([
            'title' => 'Test Todo',
            'details' => 'Test Details'
        ]);

        $this->assertEquals('not started', $todo->status);
    }

    public function test_todo_dates_are_carbon_instances(): void
    {
        $todo = Todo::factory()->create();

        $this->assertInstanceOf(\Carbon\Carbon::class, $todo->created_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $todo->updated_at);
    }

    public function test_todo_can_be_updated(): void
    {
        $todo = Todo::factory()->create();
        $newTitle = 'Updated Title';

        $todo->update(['title' => $newTitle]);

        $this->assertEquals($newTitle, $todo->fresh()->title);
    }

    public function test_todo_can_be_soft_deleted(): void
    {
        $todo = Todo::factory()->create();

        $todo->delete();

        $this->assertSoftDeleted($todo);
    }
}
