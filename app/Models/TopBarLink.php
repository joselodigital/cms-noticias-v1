<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopBarLink extends Model
{
    protected $fillable = [
        'label',
        'url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
