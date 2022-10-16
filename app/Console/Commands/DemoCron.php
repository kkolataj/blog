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

        $res = $client->request(
            'GET',
            'https://api.nbp.pl/api/exchangerates/rates/c/usd/2022-10-14/?format=json');

        if ($res->getStatusCode() == 200) {
            $content = $res->getBody()->getContents();
            $array = json_decode($content, true);
            $rates = $array['rates'][0]['ask'];

            \Log::info("_____________________________________________________________________");

            if ($rates > 1) {
                \Log::info('More than 1');
            }
            if ($rates < 1) {
                \Log::info('Less than 1');
            }
            if ($rates === 5.0368) {
                \Log::info('Is equal to 5.0368');
            } else {
                \Log::info($rates);
            }

        } else {
            \Log::info("ERROR HERE!");
        }
    }
}
