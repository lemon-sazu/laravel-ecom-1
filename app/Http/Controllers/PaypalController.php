<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaid;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    //
    public function getExpressCheckout($orderId){

        $checkoutData = $this->checkoutData($orderId);

        $provider = new ExpressCheckout();
         $response = $provider->setExpressCheckout($checkoutData);

         return redirect($response['paypal_link']);

    }

    private function checkoutData($orderId){
        $cart = \Cart::session(auth()->id());

        $cartItem = array_map(function ($item){
            return [
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['quantity']
            ];
        }, $cart->getContent()->toarray());

        $checkoutData = [
            'items' => $cartItem,
            'return_url' => route('paypal.success', $orderId),
            'cancel_url' => route('paypal.cancel'),
            'invoice_id' => uniqid(),
            'invoice_description' => 'Orders Description',
            'total' => $cart->getTotal()
        ];
        return $checkoutData;
    }

    public function getExpressCheckoutSuccess(Request $request, $orderId){
        $token = $request->get('token');
        $payerId = $request->get('PayerID');
        $provider = new ExpressCheckout();
        $checkoutData = $this->checkoutData($orderId);

        $response = $provider->getExpressCheckoutDetails($token);
        if(in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])){
            $payment_status = $provider->doExpressCheckoutPayment($checkoutData, $token, $payerId);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

            if(in_array($status, ['Completed', 'Processed'])) {
                $order = Order::find($orderId);
                $order->is_paid = 1;
                $order->save();
                \Cart::session(auth()->id())->clear();
                // send email
                Mail::to($order->user->email)->send(new OrderPaid($order));

                return redirect()->route('home')->withMessage('Payment Successful.');
            }
        }
        dd('Payment Successful.');
    }
    public function cancelPage(){
        dd('payment failed');
    }
}
