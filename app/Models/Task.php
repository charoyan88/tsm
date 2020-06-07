<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }
    public function assignees()
    {
        return $this->hasManyThrough(User::class, TaskUser::class, 'task_id', 'id', 'id', 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(TaskUser::class,'task_user','task_id','user_id');
    }

}