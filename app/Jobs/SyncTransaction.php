<?php

namespace App\Jobs;

use App\Services\EtherscanService;
use App\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $address;

    protected $params;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($address, $params = null)
    {
        $this->address = $address;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $etherscanService = new EtherscanService();

        $page = is_array($this->params) && isset($this->params['page']) ? intval($this->params['page']) : 1;
        $offset = is_array($this->params) && isset($this->params['offset']) ? intval($this->params['offset']) : 1000;

        $response = $etherscanService
            ->getNormalTransactions($this->address, $page, $offset);

        if (intval($response['status']) !== 1){
            return;
        }

        Transaction::createMany($response['result']);
    }
}
