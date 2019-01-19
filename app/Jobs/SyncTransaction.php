<?php

namespace App\Jobs;

use App\Event;
use App\Services\EtherscanService;
use App\Transaction;
use App\Watcher;
use App\WhiteAddress;
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
        \Log::info($this->watcher->sync_block_number);
        $response = $etherscanService
            ->getNormalTransactions($this->watcher->address, $this->watcher->sync_block_number);

        if (intval($response['status']) !== 1){
            return;
        }

        $this->handleEventData($response, hexdec($transactionCount['result']));

    }

    protected function handleEventData(array $response, $blockNumber = 0)
    {
        $count = count($response['result']);
        if (intval($response['status']) && $count > 0){
            $allAddress = WhiteAddress::all();

            $whites = $allAddress->filter(function ($item){
               return $item->is_white === true;
            })->map(function ($item){
                return strtolower($item->address);
            });;

            $blacks = $allAddress->filter(function ($item){
                return $item->is_white === false;
            })->map(function ($item){
                return strtolower($item->address);
            });;
            $hasEventBool = false;
            $score = 0;
            $cleanIncome = 0;
            $unknownIncome = 0;
            foreach ($response['result'] as $key => $transaction) {
                if (strtolower($transaction['to']) == strtolower($this->watcher->address)
                    && intval($transaction['value']) > 0){
                    // black list ??
                    $hasEvent = Event::query()
                        ->where('hash', $transaction['hash'])
                        ->where('address', strtolower($transaction['to']))
                        ->where('from', strtolower($transaction['from']))
                        ->count();
                    if ($hasEvent === 0){
                        $hasEventBool = true;
                        if ($blacks->contains(strtolower($transaction['from']))){
                            $status = 2;
                            $score = 100;
                        }elseif ($whites->contains(strtolower($transaction['from']))){
                            $status = 1;
                            $cleanIncome = bcadd($transaction['value'], $cleanIncome);
                        }else{
                            $status = 0;
                            $unknownIncome = bcadd($transaction['value'], $unknownIncome);
                        }
                        $this->watcher->events()->firstOrCreate([
                            'hash' => $transaction['hash'],
                            'address' => strtolower($transaction['to']),
                            'value' => $transaction['value'],
                            'from' => strtolower($transaction['from']),
                            'origin_data' => $transaction,
                            'status' => $status
                        ]);
                    }

                }

                if ($key === $count -1) {
                    $this->watcher->block_number = $blockNumber;
                    $this->watcher->sync_block_number = $transaction['blockNumber'];
                }
            }
            if ($score === 100){
                // 黑名单
                $this->watcher->score = 100;
            }else{
                if($hasEventBool){
                    $this->watcher->score = bcdiv($unknownIncome, bcadd($unknownIncome, $cleanIncome));
                }

            }

            $this->watcher->save();
        }
    }
}
