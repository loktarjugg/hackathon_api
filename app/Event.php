<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'address',
        'value',
        'hash',
        'from',
        'origin_data',
        'status',
        'tag'
    ];

    protected $casts = [
        'origin_data' => 'array'
    ];
}
