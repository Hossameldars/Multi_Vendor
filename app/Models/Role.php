<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    
    public function abilities()
    {
        return $this->hasMany(RoleAbility::class, 'role_id');
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id')
                    ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_abilities', 'role_id', 'permission_id')
                    ->withPivot('type')
                    ->withTimestamps();
    }
}