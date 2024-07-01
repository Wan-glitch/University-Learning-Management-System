<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Roles extends Model
{
    use HasFactory;
    use HasRoles;
    protected $table = 'roles';




    public function users()
    {

        return $this->hasMany(User::class, 'role');
    }

    public function hasRoleParent()
    {
        return $this->belongsTo(PermParent::class, 'perm_parent');
    }


    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
