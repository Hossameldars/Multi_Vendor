<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];

    // Permission ينتمي لكتير من الـ roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_abilities', 'permission_id', 'role_id')
                    ->withPivot('type')
                    ->withTimestamps();
    }

    // Permission له كتير من الـ abilities
    public function abilities()
    {
        return $this->hasMany(RoleAbility::class, 'permission_id');
    }
}