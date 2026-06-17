<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAbility extends Model
{
    protected $fillable = ['role_id', 'permission_id', 'type'];

    // ينتمي لـ Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // ينتمي لـ Permission
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}