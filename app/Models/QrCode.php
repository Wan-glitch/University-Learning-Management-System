<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'generated_at', 'expires_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'qr_code_id');
    }
}
