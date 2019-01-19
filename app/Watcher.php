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

    public function events()
    {
        return $this->hasMany(Event::class, 'address', 'address');
    }
}
