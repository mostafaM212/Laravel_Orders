<?php

namespace App\Requests;

use http\Env\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class BaseRequestForm
{
    protected $request;
    private $status = true;
    private $errors = [];
    abstract public function rules(): array;

    public function __construct(Request $request = null ,$forceDie = true )
    {
        if (!is_null($request)) {
            $this->request = $request;
            $rules = $this->rules();
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
               if ($forceDie){
                   $error= $validator->errors()->toArray();
                   $error = ValidationException::withMessages($error);
               }else{
                   $this->status = false;
                   $this->errors = $validator->errors()->toArray();

               }

            }

        }
    }

    public function getStatus(){
        return $this->status;
    }
    public function getErrors(){
        return $this->errors;
    }
    public function getRequest(){
        return $this->request;
    }
}
