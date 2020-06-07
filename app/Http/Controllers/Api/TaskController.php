<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index($keyword = null)
    {
        try {
            $tasks = $this->taskService->getAll($keyword);
            return response()->json(['status' => 'success', 'data' => $tasks], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error'], 400);
        }
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $task = [
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => Status::where('name', 'New')->first()->id,
            'author_id' => Auth::user()->id,
        ];
        $task = Task::create($task);
        $assignees = [];
        if (count($request->assignees) > 0) {
            foreach ($request->assignees as $item) {
                $assignees[] = ['task_id' => $task->id, 'user_id' => $item];
            }
            DB::table('task_user')->insert($assignees);
        }
        return response()->json(['status' => 'success', 'data' => $task->toJson()], 200);
    }

    public function update($id, Request $request)
    {
        $task = Task::find($id);
        try {
            switch ($request->item) {
                case "assignees":
                    $task->members()->sync($request->value);
                    break;
                default:
                    if ($task->update([$request->item => $request->value])) {
                        break;
                    }
            }
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error'], 400);
        }
    }
}