<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Faculty;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use BasementChat\Basement\Traits\HasPrivateMessages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_no',
        'user_status',
        'role',
        'faculty',
        'created_by',
        'updated_by',
        'social_id',
        'social_type',
        'notify_bulletins',

    ];
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
                    ? asset('storage/' . $this->profile_photo_path)
                    : asset('images/default-profile-photo.png'); // Ensure this path is correct and the file exists
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notify_bulletins' => 'boolean',
    ];

    public function GotRole()
    {
        return $this->belongsTo(Role::class, 'role'); // References `role` column
    }

    public function HasFaculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty'); // References `faculty` column
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')
                    ->withPivot('submission_date', 'status', 'files')
                    ->using(TaskUser::class)
                    ->withTimestamps();
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

    public function bulletins()
    {
        return $this->belongsToMany(Bulletin::class, 'bulletin_user');
    }


}
