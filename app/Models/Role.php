<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'RoleID';

    protected $fillable = [
        'RoleName',
    ];

    public function permissions()
    {
        return $this->belongsToMany(
            Entity::class,
            'rolesrights',
            'role_id',
            'entity_id'
        )
            ->withPivot('action_id')
            ->withTimestamps();
    }

    public function actions()
    {
        return $this->belongsToMany(
            Action::class,
            'rolesrights',
            'role_id',
            'action_id'
        )
            ->withPivot('entity_id')
            ->withTimestamps();
    }
}