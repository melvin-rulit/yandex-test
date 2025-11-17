<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tasks.{taskId}', function (User $user, int $taskId): bool {
    return Task::query()
        ->whereKey($taskId)
        ->whereHas('participants', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })
        ->exists();
});


