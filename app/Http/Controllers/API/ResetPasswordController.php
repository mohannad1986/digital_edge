<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Requests\API\ResetPasswordRequest;
USE Ichtrojan\Otp\Models\Otp;
use Illuminate\Support\Facades\Hash;
use App\models\User;


class ResetPasswordController extends Controller
{
    private $otp;

    public function __construct()
    {
       $this->otp = new Otp;

    }

    public function passwordReset(ResetPasswordRequest $request)
    {
        $otp2=$this->otp->validate($request->email,$request->otp);
        if(!$otp2->status){

            return response()->json(['error'=> $otp2],401);
            $user= user::where('email',$request->email)->first();
            $user->update(['password'=>Hash::make($request->password)]);

            $user->tokens()->delete();

            $success['success']=true;
            return response()->json($success,200);
          }

    }
}
