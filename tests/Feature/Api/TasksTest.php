<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{
    /**
     * @test
     */
    public function test_api()
    {
        $indexResponse = $this->getJson(route('tasks.index'));
        $indexResponse->assertOk();

        /** @var Task $task */
        $task = Task::factory()->make();

        $taskStoreArray = $task->toArray();
        $taskStoreArray['expected_at'] = $task->expected_at->toDateTimeString();
        $storeResponse = $this->postJson(route('tasks.store'), $taskStoreArray);

        $storeResponse->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'description', 'status', 'status_id', 'expected_at', 'created_at', 'updated_at']
            ]);

        $data = $storeResponse->json('data');

        $updateResponse = $this->putJson(route('tasks.update', ['task' => $data['id']]) ,[
            'description' => Task::factory()->make()->description
        ]);
        $updateResponse->assertOk();
        if ($data['description'] === $updateResponse->json('data')['description'])
            $this->fail('After update model`s value didn`t change');
        $data['description'] = $updateResponse->json('data')['description'];

        $showResponse = $this->get(route('tasks.show', ['task' => $data['id']]));
        $showResponse->assertOk();
        $diff = array_diff_assoc(
            $showResponse->json('data'),
            $data
        );
        if (count($diff) > 0)
            $this->fail('Data after update is not matching expected data');

        $destroyResponse = $this->delete(route('tasks.destroy', ['task' => $data['id']]));
        $destroyResponse->assertNoContent();
        $task->expected_at = $data['expected_at'];
        $task->description = $data['description'];
        $this->assertDatabaseMissing('tasks', $task->toArray());


    }
}
