<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'pic'];


    public function hasPIC(){
        return $this->belongsTo(User::class, 'pic');
    }



    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'faculty');
    }

}
