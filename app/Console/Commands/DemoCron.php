<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BookController;
use GuzzleHttp\Client;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        $data = [
                'name' => 'laravel heheszek',
                'detail' => 'Lorem ipsum'
            ];

        $request = new \Illuminate\Http\Request($data);

        $store = new BookController();
        $book = $store->store($request);

        // Guzzle fetch
        $client = new Client(['verify' => false]);

        $res = $client->request('GET', 'https://api.nbp.pl/api/exchangerates/rates/c/usd/2022-10-14/?format=json',['verify' => false]);

        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
            \Log::info("RESPONSE!", $response_data);
        } else {
            \Log::info("ERROR HERE!");
        }

        \Log::info("Cron is working fine!");
    }
}
