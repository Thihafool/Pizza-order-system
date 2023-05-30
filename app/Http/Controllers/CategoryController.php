<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CategoryController extends Controller
{
    //direct category list page
    public function list(){

    // dd( $_REQUEST['key']);
    // dd(request('key'));

        $categories = Category::when(request('key'),function($query){
            $query->where('name','like','%'.request('key').'%');
        })
        ->orderBy('id','desc')->paginate(4);

        // dd($categories);
        // $categories->appends(request()->all());

        return view ('admin.category.list',compact('categories'));
    }

    //direct category create page
    public function createPage(){
        return view ('admin.category.create');
    }

    //create category
    public function create(Request $request){
        // dd($request->all());
        $this->categoryValidationCheck($request);
        $data =$this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }


        //delete category
        public function delete($id){
            Category::find($id)->delete();
            // Category::where('id',$id)->delete();
            return back()->with(['deleteSuccess'=>'Category Deleted..']);
        }

        //edit category
        public function edit($id) {
            $category =Category::where('id',$id)->first();
            return view ('admin.category.edit',compact('category'));
        }

        //update category
        public function update( Request $request){
            $this->categoryValidationCheck($request);
            $data = $this->requestCategoryData($request);

            $id = $request->categoryId;

            Category::where('id',$id)->update($data);
            return redirect()->route('category#list');
        }



    // category validation check
    private function categoryValidationCheck($request ){


        Validator::make($request->all(),[
            'categoryName' => 'required|min:4|unique:categories,name,'.$request->categoryId
        ])->validate();
    }

    // request category data
    private function requestCategoryData($request){
        return [
            'name' =>$request->categoryName,
        ];
    }



}

