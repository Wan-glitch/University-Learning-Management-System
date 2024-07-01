<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'due_date',
        'created_by',
        'updated_by',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function hasCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user')
                    ->withPivot('submission_date', 'status', 'files')
                    ->using(TaskUser::class)
                    ->withTimestamps();
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function files()
    {
        return $this->hasMany(File::class, 'task_id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskUser::class);
    }

}
