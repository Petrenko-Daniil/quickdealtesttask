<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest\TaskStoreRequest;
use App\Http\Requests\TaskRequest\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TaskController extends ApiController
{
    /**
     * @OA\Get(
     *      path="/api/tasks",
     *      operationId="getTasks",
     *      tags={"Tasks"},
     *      summary="Get list of tasks",
     *      description="Returns list of tasks",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     * Документация к API не дополнена, ввиду ограниченности по времени
     */
    public function index(): ResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function store(TaskStoreRequest $request): TaskResource
    {
        return new TaskResource(
            Task::create($request->toArray())
        );
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(TaskUpdateRequest $request, Task $task): TaskResource
    {
        $task->update(
            $request->toArray()
        );
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response('', 204);
    }

    public function getBy(Request $request, string $field): ResourceCollection|Response
    {
        if (!Task::isFieldSearchable($field)){
            return response('Given field is not searchable', 400);
        }
        $request->validate([
            'search' => [Task::getSearchableFieldValidation($field), 'required']
        ]);
        return TaskResource::collection(
            Task::where($field, $request->search)->get()
        );
    }
}
