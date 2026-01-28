<?php

namespace App\Requests;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class BaseRequestFormApi
{
    public $request;
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
                   $this->status = false;
                   $this->errors= $validator->errors()->toArray();

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
