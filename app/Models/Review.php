<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'rating', 'comment', 'occasion_type', 'show_on_home'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}