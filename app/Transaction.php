<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'blockNumber',
        'timeStamp',
        'hash',
        'nonce',
        'transactionIndex',
        'from',
        'to',
        'value',
        'gas',
        'gasPrice',
        'isError',
        'txreceipt_status',
        'input',
        'contractAddress',
        'cumulativeGasUsed',
        'gasUsed',
        'confirmations'
    ];

    protected $casts = [
        'timeStamp' => 'date'
    ];
}
