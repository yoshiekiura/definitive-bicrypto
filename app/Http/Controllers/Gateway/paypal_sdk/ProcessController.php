<?php

namespace App\Http\Controllers\Gateway\paypal_sdk;

use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Http\Client\Exception\HttpException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class ProcessController extends Controller
{

    /*
     * Paypal Gateway
     */
    public static function process($deposit)
    {
        $paypalAcc = json_decode($deposit->gateway_currency()->gateway_parameter);

        // Creating an environment
        $clientId = "$paypalAcc->clientId";
        $clientSecret = "$paypalAcc->clientSecret";

        $environment = new ProductionEnvironment(
            $paypalAcc->clientId,     // ClientID
            $paypalAcc->clientSecret
        );
        $client = new PayPalHttpClient($environment);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                             "intent" => "CAPTURE",
                             "purchase_units" => [[
                                 "reference_id" => $deposit->trx,
                                 "amount" => [
                                     "value" => number_format($deposit->final_amo, 2),
                                     "currency_code" => $deposit->method_currency
                                 ]
                             ]],
                             "application_context" => [
                                  "cancel_url" => route(gatewayRedirectUrl()),
                                  "return_url" => route('ipn.paypal_sdk')
                             ]
                         ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
        }
        $send['redirect'] = true;
        $send['redirect_url'] = $response->result->links['1']->href;

        return json_encode($send);
    }

    public function ipn()
    {
        $paypalAcc = GatewayCurrency::where('gateway_alias','paypal_sdk')->latest()->first();
        $paypalAcc = json_decode($paypalAcc->gateway_parameter);
        // Creating an environment
        $clientId = "$paypalAcc->clientId";
        $clientSecret = "$paypalAcc->clientSecret";

        $environment = new ProductionEnvironment(
            $paypalAcc->clientId,     // ClientID
            $paypalAcc->clientSecret
        );
        $client = new PayPalHttpClient($environment);

        // Here, OrdersCaptureRequest() creates a POST request to /v2/checkout/orders
        // $response->result->id gives the orderId of the order created above

        $paymentId = \request('token');
        $request = new OrdersCaptureRequest($paymentId);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

        }catch (HttpException $ex) {
            echo $ex->statusCode;
        }
        $data =  Deposit::where('trx',$response->result->purchase_units['0']->reference_id)->orderBy('id','desc')->first();
        if ($response->result->status == "COMPLETED" && $data->status == '0') {
            PaymentController::userDataUpdate($data->trx);
            $notify[] = ['success', 'Payment Success.'];
        }else{
            $notify[] = ['error', 'Failed to process payment'];
        }
        return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
    }

}
