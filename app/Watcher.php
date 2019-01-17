<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watcher extends Model
{
    protected $fillable = [
        'address',
        'block_number',
        'sync_block_number',
        'score'
    ];
}
