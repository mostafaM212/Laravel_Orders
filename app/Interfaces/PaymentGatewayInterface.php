<?php
namespace App\Interfaces;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function pay(float $amount, array $options = []): array;
}
