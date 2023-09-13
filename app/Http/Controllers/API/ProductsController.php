<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;



class ProductsController extends Controller
{

    use ApiResponseTrait;

    // public function __construct()
    // {
    //      $this->middleware('Admin',['except' => ['index']]);
    //      $this->middleware('auth:sanctum');

    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return $this->apiresponse(null,' المنتجات  بنجاح جلبناها لك',200);

        $product= products::paginate();
         return $this->apiresponse($product,' المنتجات  بنجاح جلبناها لك',200);

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



        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,max:255',
            'description' => 'required|max:255',
            'image' => 'required',

        ]);
        if ($validator->fails()) {

            return $this->apiresponse(null,$validator->errors(),400);

        }


        try {

            if ($request->hasFile('image')){

                $image = $request->file('image');
                $fileExt = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore =time().'.'.$fileExt;
                // $file_name = $image->getClientOriginalName();
                $request->image->storeAs('product/',$fileNameToStore,$disk ='products');

            }

            $product = new products();
            $product->name=$request->name;
            $product->image=$fileNameToStore ;

            $product->description=$request->description;

            $product->save();

            if($product){

                return $this->apiresponse(null,'تم اضافة المنتج  بنجاح',201);
               }

               return $this->apiresponse(null,'لم يتم اضافة المنتج',400);





            }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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



            $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,max:255',
            'description' => 'max:255',

        ]);
        if ($validator->fails()) {

            return $this->apiresponse(null,$validator->errors(),400);

        }

        try {
            $product =products::findorFail($id);
            $product->update($request->all());

             if($product){
                return $this->apiresponse( $product,'تم تعديل المنتج بنجاح',201);

             }



        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // +++++++++++++++++++++
        try {
        $product=  products::findOrFail($id);

           if($product){
           Storage::disk('products')->delete('product/'.$product->image);



           products::destroy($id);

           return $this->apiresponse(null,'تم حذف المنتج بنجاح',204);


          }

        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }



        // +++++++++++++++++++
    }


    public function assign_product (Request $request)
    {

        $product= products::findOrFail($request->product_id);
          $product->user_id=$request->input('user_id');
            $product->save();
            return $this->apiresponse(null,'تم اضافة المالك بنجاح',201);


    }

    public function get_user_products ($id)
    {

        $user= User::findOrFail($id);
          $products =$user->products;
          if($products){
            return $this->apiresponse($products,'تم جلب المنتجات الخاصة بالمستخدم بنجاح',201);


          }



    }
}
