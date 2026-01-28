<?php

namespace App\Requests\Products;

use App\Requests\BaseRequestFormApi;

class UpdateProductValidator extends BaseRequestFormApi
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
