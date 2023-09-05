<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
EmailverificationRequest;
use App\Notifications\ResetPasswordVerificationNotification;

use  App\Http\Requests\API\ForgetPasswordRequest;

class ForgetPasswordController extends Controller
{
    public function forgotPassword(ForgetPasswordRequest $request)
    {



    }
   
}



