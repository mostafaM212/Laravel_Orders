<?php

namespace App\Requests\Orders;

use App\Requests\BaseRequestFormApi;

class UpdateOrderValidator extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }
}
