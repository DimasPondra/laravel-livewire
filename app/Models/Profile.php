<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'address', 'province_id', 'city_id', 'subdistrict_id',
        'user_id'
    ];
}
