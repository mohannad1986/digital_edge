<?php

// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;

// class VerifyEmailController extends Controller
// {
//     public function index()
//     {
//         $user = User::where('email_verification_code', request()->input('code'))->firstOrFail();

//         if ($user && !$user->is_email_verified()) {
//             $user->markEmailAsVerified();

//             return view('login')->with(['message' => 'Your email has been verified']);
//         } else {
//             abort(404);
//         }
//     }

// }
