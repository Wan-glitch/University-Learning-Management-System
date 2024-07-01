<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermParent extends Model
{
    use HasFactory;


    protected $table = 'perm_parent';

    protected $fillable = [
        'name',
    ];


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'perm_parent', 'id');
    }
}
