<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $table = 'actions';
    protected $primaryKey = 'ActionID';
    protected $fillable = ['ActionName'];

    public function entities()
    {
        return $this->belongsToMany(
            Entity::class,
            'entity_actions',
            'ActionID',
            'EntityID'
        );
    }
}