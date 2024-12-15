<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::factory()->count(5)->create(['status' => 'not started']);
        Todo::factory()->count(3)->create(['status' => 'in progress']);
        Todo::factory()->count(2)->create(['status' => 'completed']);
    }
}
