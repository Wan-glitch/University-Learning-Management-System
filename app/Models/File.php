<?php

namespace App\Models;

use App\Models\Bulletin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task_id', 'file_path', 'bulletin_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class);
    }
}
