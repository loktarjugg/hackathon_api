<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019/1/12
 * Time: 12:19
 */

namespace App\Services;


use GuzzleHttp\Client;

class EtherscanService
{
    const BASE_REQUEST_URL = 'https://api-rinkeby.etherscan.io/api';
    const API_KEY = '';


    public function getNormalTransactions(string $address, $page = 1, $offset = 50, $startBlock = 700000, $endBlock = 99999999)
    {
        // https://api.etherscan.io/api?module=account&action=txlist&address=0xddbd2b932c763ba5b1b7ae3b362eac3e8d40121a&startblock=0&endblock=99999999&page=1&offset=10&sort=asc&apikey=YourApiKeyToken

        return $this->requestGET([
            'module' => 'account',
            'action' => 'txlist',
            'address' => $address,
            'startblock' => $startBlock,
            'endblock' => $endBlock,
            'page' => $page,
            'offset' => $offset,
            'sort' => 'asc'
        ]);

    }

    public function getTransactionCount(string $address)
    {
        // https://api.etherscan.io/api?module=proxy&action=eth_getTransactionCount&address=0x2910543af39aba0cd09dbb2d50200b3e800a63d2&tag=latest&apikey=YourApiKeyToken
        return $this->requestGET([
            'module' => 'proxy',
            'action' => 'eth_getTransactionCount',
            'address' => $address,
            'tag' => 'latest',
        ]);
    }

    protected function requestGET(array $params, $url = null)
    {
        $params = $this->getParams($params);

        try{
            $client = $this->getHttpClient();
            $response = $client->request('GET','', ['query' => $params])
                ->getBody()->getContents();

            $response = json_decode($response, true, 512, JSON_BIGINT_AS_STRING);

            if (JSON_ERROR_NONE === json_last_error()) {
                return (array)$response;
            }

            return false;
        }catch (\Exception $e){
            \Log::error($e->getMessage(), (array) $e);
            return false;
        }
    }

    protected function getHttpClient()
    {
        return new Client([
        'base_uri' => self::BASE_REQUEST_URL
    ]);
    }

    protected function getParams(array $params) {
        return array_filter(array_merge($params, [
            'apikey' => self::API_KEY
        ]));
    }
}