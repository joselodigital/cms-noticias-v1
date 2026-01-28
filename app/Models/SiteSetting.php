<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'logo_light_path',
        'logo_dark_path',
        'favicon_path',
    ];
}
