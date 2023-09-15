<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\ResetPasswordVerificationNotification;

use  App\Http\Requests\API\ForgetPasswordRequest;

class ForgetPasswordController extends Controller
{
    public function forgotPassword(ForgetPasswordRequest $request)
    {

       $input=$request->only('email');
       $user= user::where('email',$input)->first();
       $user->notify(new ResetPasswordVerificationNotification());
       $succes['success']=true;
       $succes['message']="تم ارسال رمز التحقق الى بريدكم الالكتروني";

       return response()->json($succes,200);

    }

}



