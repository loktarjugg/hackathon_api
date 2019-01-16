<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalException;
use App\Jobs\SyncTransaction;
use App\Services\EtherscanService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $etherscanService;

    public function __construct(EtherscanService $etherscanService)
    {
        $this->etherscanService = $etherscanService;
    }
    public function syncTransaction(string $address)
    {
        $response = $this->etherscanService->getNormalTransactions($address);

        dd($response);
        if (!$response){
            throw new InternalException('getTransactionCount error');
        }
        $count = hexdec($response['result']);

        $offset = \Request::filled('offset') ? intval(\Request::input('offset')) : 100;

        if ($count > $offset){
            // 拆成多个队列
            $pagedNumber = intval($count / $offset);
            for ($i =1; $i <= $pagedNumber; $i++){
                $this->dispatch(new SyncTransaction($address, [
                    'page' => $i,
                    'offset' => $offset
                ]));
            }

            return response()->json([]);
        }

        $this->dispatch(new SyncTransaction($address));

        return response()->json([]);
    }
}
