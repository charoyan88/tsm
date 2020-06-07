<?php

namespace App\Services;

use App\Models\Task;


class TaskService
{
    public function getAll($keyword,$id=null)
    {
        $data = array();
        $tasks = Task::with('author', 'status', 'assignees');
        if($id)
        {
            $tasks = $tasks->where('author_id',$id);
        }
        if ($keyword) {
            $tasks = $tasks->where('name', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
        }
        $tasks = $tasks->get();
        foreach ($tasks as $key => $task) {
            $data[$key]['id'] = $task->id;
            $data[$key]['name'] = $task->name;
            $data[$key]['description'] = $task->description;
            $data[$key]['author'] = $task->author->email;
            $data[$key]['status'] = $task->status->name;
            $data[$key]['assignees'] = $task->assignees->toArray();
        }
        return $data;
    }

}