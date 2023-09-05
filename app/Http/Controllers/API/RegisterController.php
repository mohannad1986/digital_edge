<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\HasApiTokens;

 use App\Notifications\EmailverificationNotification;


class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first' => 'required',
            'last' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }
//   ++++++++++++++++++++++++++++++++++++++++++++++++++++++
 /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function registerverrfication(Request $request)
  {
     $validator = Validator::make($request->all(), [
        'first' => 'required',
        'last' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'c_password' => 'required|same:password',
    ]);

    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    $success['name'] =  $user->first;
    $success['success'] = true;


    $user->notify(new EmailverificationNotification());

    return  response()->json($success,200);
  }

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++
public function login(Request $request)
{
    $validator = Validator::make($request->only('email', 'password'), [
        'email' => ['required', 'email', 'exists:users,email'],
        'password' => ['required', 'min:6', 'max:255', 'string'],
    ]);
    if ($validator->fails())
        return response()->json($validator->errors(), 400);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = $request->user();
        $data =  [
            'token' => $user->createToken('Sanctom+Socialite')->plainTextToken,
            'user' => $user,
            'message'=>'تم تسجيل الدخول بنجاح'
        ];
        return response()->json($data, 200);
    }
}
// ++++++++++++++++++++++++++++
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function loginphone(Request $request)
    {
        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])){
            // $user = Auth::user();
            $user =auth('sanctum')->user;
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->first;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }


    public function logout(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }
}
