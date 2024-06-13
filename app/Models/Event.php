<?php

namespace App\Models;

use App\Models\EventGuest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'date', 'time', 'color', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function guests()
    {
        return $this->hasMany(EventGuest::class);
    }
}
