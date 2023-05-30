<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //get all product list
    public function productList(){
        $products = Product::get();
        $users = User::get();

        $data = [
            'product' =>$products,
            'user' => $users
        ];
        return response()->json($data,200);
    }

    //get all category list
    public function categoryList(){
        $category = Category::orderBy('id','desc')->get();
        return response()->json($category,200);
    }

    //create category
    public function categoryCreate(Request $request){

        $data = [
            'name' =>$request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
      $response = Category::create($data);
      return response()->json($response,200);

    }

    public function deleteCategory($id) {
        $data = Category::where('id',$id)->first();
        if(isset($data)){
            Category::where('id',$id)->delete();
            return response()->json(['status' => true,'message' => 'delete success','delete Data' => $data],200);
        }else

            return response()->json(['status' => false,'message' => 'there is no data'],404);

    }
    //category details
    public function categoryDetails($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            return response()->json(['status' => true,'category' => $data],200);
        }else

            return response()->json(['status' => false,'category' => 'there is no category'],404);


    }
    // public function categoryDetails(Request $request){
    //     $data = Category::where('id',$request->category_id)->first();

    //     if(isset($data)){
    //         Category::where('id',$request->category_id)->delete();
    //         return response()->json(['status' => true,'category' => $data],200);
    //     }else

    //         return response()->json(['status' => false,'category' => 'there is no category'],404);


    // }


    //delete data
    // public function deleteCategory(Request $request) {
    //     $data = Category::where('id',$request->category_id)->first();
    //     if(isset($data)){
    //         Category::where('id',$request->category_id)->delete();
    //         return response()->json(['status' => true,'message' => 'delete success'],200);
    //     }else

    //         return response()->json(['status' => false,'message' => 'there is no data'],200);

    // }

        //update category
        public function categoryUpdate(Request $request){
            $categoryId = $request->category_id;

            $dbSource = Category::where('id',$categoryId)->first();

            if(isset($dbSource)){

            $data = $this->getCategoryData($request);
            Category::where('id',$categoryId)->update($data);

            $response = Category::where('id',$categoryId)->first();

            return response()->json(['status' => true,'message' => 'category updated successfully','category' => $response],200);
        }

            return response()->json(['status' => false,'message' => 'there is no category to update'],404);
        }


    //get contact data
    public function createContact(Request $request){
        $data = $this->getContactData($request);
        Contact::create($data);
        $contact = Contact::orderBy('created_at','desc')->get();
        return response()->json($contact,200);

    }
    private function getContactData($request){
        return [
            'name' =>$request->name,
            'email' =>$request->email,
            'message' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    //get category data
    private function getCategoryData ($request){
        return [
            'name' => $request->category_name,
            'updated_at' => Carbon::now()
        ];
    }

}
