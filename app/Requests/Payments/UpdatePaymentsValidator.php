<?php

namespace App\Requests\Payments;

use App\Requests\BaseRequestFormApi;

class UpdatePaymentsValidator extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [
            'name'=> 'required|min:3',
            'price'=> 'required|min:2|numeric',
            'quantity'=> 'required|min:0|numeric',
        ];
    }
}
