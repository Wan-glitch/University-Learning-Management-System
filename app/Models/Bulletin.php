<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category', 'faculty_id', 'created_by'];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'bulletin_user', 'bulletin_id', 'user_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function attachments()
    {
        return $this->hasMany(File::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'bulletin_user');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
