<?php

namespace App\Providers;


use App\Models\Task;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Task::class);
    }
}