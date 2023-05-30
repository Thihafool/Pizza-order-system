<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\FunctionNode;

class ProductController extends Controller
{
    //product list
    public function list(){
        $pizzas = Product::select('products.*','categories.name as category_name')->when(request('key'),function($query){
            $query->where('products.name','like','%'.request('key').'%');
        })
        ->leftjoin('categories','products.category_id','categories.id')
        ->orderBy('products.created_at','desc')->paginate(3);

        return view ('admin.product.pizzaList',compact('pizzas'));
    }
    //direct pizza create page
    public function createPage(){
        $categories = Category::select('id','name')->get();
        return view('admin.product.Pizzacreate',compact('categories'));
    }
    // product create
    public function create(Request $request){


        $this->productValidationCheck($request,'create');
        $data = $this->requestProductInfo($request);

            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#list');

    }
    //delete product

    public function delete($id){
        Product::find($id)->delete();
        return redirect()->route('product#list')->with(['deleteSuccess' => 'Successfully Deleted....']);

    }
    //edit product
    public function edit($id){
        $pizza = Product::select('products.*','categories.name as category_name')->where('products.id',$id)
        ->leftjoin('categories','products.category_id','categories.id')
        ->first();

        return view('admin.product.edit',compact('pizza'));
    }
    //direct update pizzaPage
    public function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.product.update',compact('pizza','category'));
    }
    //update pizza
    public function update(Request $request){
        $this->productValidationCheck($request,'update');
        $data =$this->requestProductInfo($request);

        if($request->hasFile('pizzaImage')){
            $oldImageName = Product::where('id',$request->pizzaId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }
            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public/'.$fileName);
            $data['image'] = $fileName;
        }
        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list');

    }

    //request product info
    private function requestProductInfo($request){
    return  [
        'category_id' =>$request->pizzaCategory,
        'name' =>$request->pizzaName,
        'description' =>$request->pizzaDescription,
        'price' =>$request->pizzaPrice,
        'waiting_time'=>$request->pizzaWaitingTime,
    ];

    }


    //product validation check
    private function productValidationCheck($request,$status){

        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,'.$request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:10',
            'pizzaPrice' => 'required|min:4',
            'pizzaWaitingTime' => 'required',
        ];
        $validationRules['pizzaImage'] = $status == 'create'?'required|mimes:png,jpg,webp,jpeg,avif,jfif':'mimes:png,jpg,webp,jpeg,avif,jfif';
        Validator::make($request->all(),$validationRules)->validate();
    }
}
