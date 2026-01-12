<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesRight extends Model
{
    use HasFactory;

    protected $table = 'rolesrights';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'RoleID',
        'EntityID',
        'ActionID',
    ];
    
}