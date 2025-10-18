<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $table = 'business_settings';

    protected $fillable = [
        'user_id',
        'business_name',
        'primary_color',
        'primary_light_color',
        'secondary_color',
        'logo',
        'form_thumbnail',
        'form_title',
    ];
}
