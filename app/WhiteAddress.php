<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhiteAddress extends Model
{
    protected $fillable = [
        'address',
        'name',
        'is_white'
    ];

    protected $casts = [
        'is_white'=>'bool'
    ];
}
