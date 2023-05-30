<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\FunctionNode;

class AdminController extends Controller
{
    //redirect changePasswordpage
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //changePassword
    public function changePassword(Request $request){
        /*
        1. All fields must be filled
        2. New password and Confirm password length must be greater than 6
        3. New password and Confirm password must be same
        4. Client Old password must be same with the DB password
        5. Password Change
        */

        $this->passwordValidationCheck($request);

        //old password fetch
        $currentUserId = Auth::user()->id;

        $user = User::select('password')->where('id',$currentUserId)->first();

        $dbHashValue = $user->password; // old password

        //check oldpassword and Dbpassword equal or not
        if(Hash::check($request->oldPassword,$dbHashValue)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];

            User::where('id',Auth::user()->id)->update($data);
            // Auth::logout();
            // return redirect()->route('category#list');
            return back()->with(['changeSuccess'=>'password changed successfully']);
        }
        return back()->with(['notMatch' => 'Old Password is not Match. Try again']);

    }

    //direct admin details page
    public function details(){
        return view ('admin.account.details');
    }

    //direct admin edit page
    public function edit(){
        return view ('admin.account.edit');
    }

    //update account info
    public function update($id ,Request $request){

        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

    if($request->hasfile('image')){
        //old image name |check =>delete |store

        $dbImage = User::where('id',$id)->first();
        $dbImage = $dbImage->image;

        if($dbImage != null){
            Storage::delete('public/'.$dbImage);
        }

        $fileName = uniqid() .$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public',$fileName);
        $data['image'] = $fileName;
    }

        User::where('id',$id)->update($data);
        // dd(Auth::user()->all()->toArray());
        return redirect()->route('admin#details')->with(['updateSuccess'=>'update account successfully']);


    }
    //admin list
    public function list(){
        $admin = User::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%')
            ->orWhere('email','like','%'.request('key').'%')
            ->orWhere('gender','like','%'.request('key').'%')
            ->orWhere('phone','like','%'.request('key').'%')
            ->orWhere('address','like','%'.request('key').'%');

        })
        ->where('role','admin')->paginate(3);
        return view ('admin.account.list',compact('admin'));

    }

    //delete account
    public function delete($id){
        User::find($id)->delete();
        return back()->with(['deleteSuccess' => 'account deleted successfully']);
    }
    //change role
    public function changeInfo($id){
        $account = User::where('id',$id)->first();
        return view ('admin.account.changeInfo',compact('account'));
    }
    //change
    public function change($id,Request $request){

        $data = $this->requestUserData($request);

        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    private function requestUserData($request){
        return [
            'role' => $request->role
        ];
    }
    //account valadition check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,webp,jpeg|file',
            'address' => 'required'
        ])->validate();
    }

    //request user data
    private function getUserData($request){
        return [
            'name' =>$request->name,
            'email' =>$request->email,
            'gender' =>$request->gender,
            'phone'=>$request->phone,
            'address' =>$request->address,
            'updated_at'=>Carbon::now()
        ];
    }


    //password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' =>'required|min:6|max:10',
            'newPassword' =>'required|min:6|max:10',
            'confirmPassword' =>'required|min:6|max:10|same:newPassword'
        ])->validate();
    }

    //admin change role
    public function changeRole (Request $request){
        $updateSource = [
            'role' => $request->role
        ];
       User::where('id',$request->userId)->update($updateSource);
    }


    //contact page
    public function contactPage (){
        $contacts = Contact::orderBy('created_at','desc')->paginate('5');


        return view('admin.user.contact',compact('contacts'));
    }

}
