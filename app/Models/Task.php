<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function status()
    {
        return $this->hasOne(Status::class, 'status_id');
    }

    public function assignees()
    {
        return $this->hasManyThrough(User::class, TaskUser::class, 'task_id', 'id', 'id', 'user_id');
    }
}