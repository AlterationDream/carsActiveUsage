<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveUse extends Model
{
    protected $fillable = [
        'user_id',
        'car_id'
    ];
}
