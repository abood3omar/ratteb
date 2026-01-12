<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',
        'name_ar',
        'name_en',
        'price',
        'price_unit',
        'capacity',
        'description',
        'image',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}