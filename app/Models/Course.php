<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name', 'description', 'faculty', 'pic', 'created_by', 'updated_by', 'year', 'term', 'status'
    ];


    public function schedules()
    {
        return $this->hasMany(CourseSchedule::class);
    }

    public function hasFaculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty');
    }

    public function hasPIC()
    {
        return $this->belongsTo(User::class, 'pic');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withTimestamps();
    }




    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function personInCharge()
    {
        return $this->belongsTo(User::class, 'pic');
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
