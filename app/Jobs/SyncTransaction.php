<?php

namespace App\Jobs;

use App\Services\EtherscanService;
use App\Transaction;
use App\Watcher;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $watcher;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Watcher $watcher)
    {
        $this->watcher = $watcher;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $etherscanService = new EtherscanService();

        $transactionCount = $etherscanService->getTransactionCount($this->watcher->address);

        $response = $etherscanService
            ->getNormalTransactions($this->watcher->address);

        if (intval($response['status']) !== 1){
            return;
        }

        $this->watcher->block_number = hexdec($transactionCount['result']);
        $this->watcher->sync_block_number = hexdec($transactionCount['result']);
        $this->watcher->save();
    }
}
