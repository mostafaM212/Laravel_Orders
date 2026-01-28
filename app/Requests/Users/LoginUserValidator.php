<?php

namespace App\Requests\Users;

use App\Requests\BaseRequestFormApi;

class LoginUserValidator extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [
            'email'=> 'required|email|min:5',
            'password'=> 'required|min:8',
        ];
    }
}
