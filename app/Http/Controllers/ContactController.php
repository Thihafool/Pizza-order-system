<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // private function getUserData($request){
    //     return [
    //         'name' =>$request->name,
    //         'email' =>$request->email,
    //         'gender' =>$request->gender,
    //         'phone'=>$request->phone,
    //         'address' =>$request->address,
    //         'updated_at'=>Carbon::now()
    //     ];
    // }


    // //password validation check
    // private function passwordValidationCheck($request){
    //     Validator::make($request->all(),[
    //         'oldPassword' =>'required|min:6|max:10',
    //         'newPassword' =>'required|min:6|max:10',
    //         'confirmPassword' =>'required|min:6|max:10|same:newPassword'
    //     ])->validate();
    // }

}
