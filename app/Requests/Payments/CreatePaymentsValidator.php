<?php

namespace App\Requests\Payments;

use App\Requests\BaseRequestFormApi;

class CreatePaymentsValidator extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [
            'payment_method'=> 'required|min:3',
        ];
    }
}
