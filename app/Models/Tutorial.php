<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'course_id', 'file_path'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
