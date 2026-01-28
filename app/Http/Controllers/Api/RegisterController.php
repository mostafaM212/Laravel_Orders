<?php

namespace App\Http\Controllers\Api;

use App\Requests\Users\CreateUserValidator;
use App\Requests\Users\LoginUserValidator;
use App\Services\UserService;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends BaseController
{
    public userService $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function register(CreateUserValidator $createUserValidator){

        if (!empty($createUserValidator->getErrors())){
            return response()->json($createUserValidator->getErrors(),406);
        }
        $user = $this->userService->createUser($createUserValidator->request->all());
        $message['user'] = $user;
        $message['token']= $user->createToken('MyApp')->plainTextToken;
        return  $this->sendResponse($message);
    }

    public function login(LoginUserValidator $loginUserValidator)
    {
        if (!empty($loginUserValidator->getErrors())) {
            return response()->json($loginUserValidator->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (auth()->attempt(['email'=>$loginUserValidator->request->input('email'),'password'=> $loginUserValidator->request->input('password')])){
            $user = $loginUserValidator->request->user();
            $message['user'] = $user;
            $message['token'] = $user->createToken('MyApp')->plainTextToken;
            return $this->sendResponse($message);
        }else{
            return $this->sendResponse(null , Response::HTTP_UNAUTHORIZED);
        }
    }
}
