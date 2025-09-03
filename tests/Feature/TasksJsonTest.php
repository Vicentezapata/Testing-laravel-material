<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;

class TasksJsonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_tasks_as_json()
    {
        $project = Project::factory()->create();
        Task::factory(3)->create(['project_id' => $project->id]);

        $response = $this->get('/tasks-json');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'due_date',
                    'project_id',
                    'created_at',
                    'updated_at',
                    'project' => [
                        'id',
                        'name',
                        'description',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }
}
