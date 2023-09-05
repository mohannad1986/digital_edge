<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use  App\Http\Requests\API\EmailverificationRequest;
use App\Notifications\EmailverificationNotification;


use Ichtrojan\Otp\Otp;

// use Ichtrojan\Otp\Models\Otp;

class EmailverificationController extends Controller
{
   private $otp;

   public function __construct()
   {
      $this->otp = new Otp;

   }

   public function sendEmailVerification (Request $request)
   {
    $request->user()->notify(new EmailverificationNotification());

    $success['success']=true;
    return response()->json($success,200);
   }

    public function email_verification(EmailverificationRequest $request)

    {
       $otp2=$this->otp->validate($request->email,$request->otp);

       if(!$otp2->status){

         return response()->json(['error'=> $otp2],401);
       }

       $user= user::where('email',$request->email)->first();
       $user->update(['email_verified_at'=>now()]);

       $success['success']=true;
       return response()->json($success,200);
    }
}
