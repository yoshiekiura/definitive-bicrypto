<?php

namespace App\Console\Commands;

use App\Models\ICO;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class MetamaskValidatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:metamask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Metamask Transactions Validator Command';

    protected $transactions;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->transactions = new Transaction();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ico_address = ICO::where('status',1)->first()->address;
        return $this->validateTransactions($ico_address);
    }
    /**
     * Validate Metamask Transaction
     *
     * @return void
     */
    public function validateTransactions($ico_address)
    {
        $master_account = $ico_address; //please paste your master Metamask account address here
        $transactions = $this->transactions->pendingTransactions(); //get Pending Transactions From Database [which are older than 20min]
        //Run foreach to check transactions one by one.
        foreach ($transactions as $transaction) {
            //get transaction information from etherscan
            $response = $this->checkWithEtherScan($transaction->txHash);
            //validate response
            if ($response && array_key_exists('result', $response)) {
                $tr_data = $response['result'];
                //validate transaction destination with our account [destination must be our master account].
                if (strtolower($tr_data['to']) == strtolower($master_account)) {
                    // Update Transaction As Success
                    $transaction->status = 2;
                    $transaction->update();
                } else {
                    // Update Transaction As Canceled
                    $transaction->status = 3;
                    $transaction->update();
                }
            } else {
                // Update Transaction As Canceled
                $transaction->status = 3;
                $transaction->update();
            }
        }
    }
    /**
     * Check Transaction With Ether Scan
     *
     * @param  mixed $transaction_hash
     * @return mixed
     */
    public function checkWithEtherScan($transaction_hash)
    {
        $api_key = "AI9Z3MDWUB8KVK1XD2ESE1QUR9BRB1JVQB"; // pase your api key here. which was copied from Etherscan.io
        $test_network = "https://api-testnet.bscscan.com/"; // in this tutorial we use only test networks
        $main_network = "https://api.bscscan.com/"; // if you want to go live you must use main network.

        $response = Http::get($test_network . "api?module=transaction&action=gettxreceiptstatus&txhash="
            . $transaction_hash . '&apikey=' . $api_key);
        return $response->json();
    }
}
