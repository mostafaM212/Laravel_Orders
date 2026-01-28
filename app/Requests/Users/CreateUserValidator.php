<?php

namespace App\Requests\Users;

use App\Requests\BaseRequestFormApi;

class CreateUserValidator extends BaseRequestFormApi
{

    public function rules(): array
    {
        return [
            'email'=> 'required|email|min:5|unique:users,email',
            'password'=> 'required|min:8|confirmed',
            'name'=> 'required|min:3',
        ];
    }
}
