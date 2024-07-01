<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskUser extends Pivot
{
    protected $table = 'task_user';

    protected $fillable = [
        'task_id', 'user_id', 'submission_date', 'status', 'files'
    ];

    protected $casts = [
        'files' => 'array'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
