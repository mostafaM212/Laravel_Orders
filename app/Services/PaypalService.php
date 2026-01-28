<?php

namespace App\Services;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalService  implements PaymentGatewayInterface
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }

    public function pay(float $amount, array $options = []): array
    {
        $this->provider->getAccessToken();

        $order = $this->provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => config('paypal.currency', 'USD'),
                        "value" => $amount
                    ]
                ]
            ]
        ]);
        return $order; // contains approval link for redirect
    }

}
