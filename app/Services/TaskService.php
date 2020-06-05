<?php

namespace App\Services;

use App\Models\Task;


class TaskService
{
    public function getAll($keyword)
    {
        $data = array();
        $tasks = Task::with('author', 'status', 'assignees');
        if ($keyword) {
            $tasks = $tasks->where('name', 'like', '%' . $keyword . '%');
        }
        $tasks = $tasks->get();
        foreach ($tasks as $key => $task) {
            $data[$key]['name'] = $task->name;
            $data[$key]['description'] = $task->description;
            $data[$key]['author'] = $task->author->first_name . " " . $task->author->last_name;
            $data[$key]['status'] = $task->status->name;
            $data[$key]['assignees'] = $task->assignees;
        }
        return $data;
    }

}