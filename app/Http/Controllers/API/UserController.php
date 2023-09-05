<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use App\Models\products;



class UserController extends Controller
{

    use ApiResponseTrait;
    public function __construct()
    {
         $this->middleware('Admin',['except' => ['update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= User::paginate();

        return $this->apiresponse($user,'تم جلب المستخدمين بنجاح',200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->apiresponse($id,'تم جلب المستخدم بنجاح',200);

        $user =User::findorFail($id);
        return $this->apiresponse($user,'تم جلب المستخدم بنجاح',200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {


        // ++++++++++++++++++
        $validator = Validator::make($request->all(), [
            'first' => 'required|unique:users,first|max:255',
            'last' => 'unique:categories,name->ar|max:255',
            'email' => 'unique:users,email',
            'phone' => 'max:13',



        ]);
        if ($validator->fails()) {

            return $this->apiresponse(null,$validator->errors(),400);

        }

         try{


            $user =User::findorFail($id);

            $user->update($request->all());

                if($user){

                    return $this->apiresponse(null,'تم تحديث المستخدم بنجاح',201);
                   }
                //    الباد رسكوست 400
                   return $this->apiresponse(null,' لم يتم تحديث المستخدم',400);

         }
         catch (\Exception $e)
         {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }


        // ++++++++++++++++++++
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=  user::findOrFail($id);
        if($user){
            user::destroy($id);
            return $this->apiresponse(null,'تم حذف المستخدم بنجاح',204);

        }
    }

 public function testformiddleware()
 {
    return $this->apiresponse(null,'ان حسابك قد تم تغعيله عن طريق الايميل',204);


 }
}
