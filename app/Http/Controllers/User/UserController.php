<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //user home page
    public function home()
    {
        $pizza = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }

    //change password page
    public function changePasswordPage()
    {
        return view('user.password.changePassword');
    }
    //change password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);

        $currentUserId = Auth::user()->id;
        $dbPassword = User::where('id', $currentUserId)->first();

        $hashValue = $dbPassword->password;
        if (Hash::check($request->oldPassword, $hashValue)) {
            $data = [
                'Password' => Hash::make($request->newPassword),
            ];
            User::where('id', $currentUserId)->update($data);
            // Auth::logout();
            return back()->with(['changeSuccess' => 'password Changed Successfully']);

        }
        return back()->with(['notMatch' => 'password not match try again']);

    }
    //user account change page
    public function accountChangePage()
    {
        return view('user.profile.account');
    }

    //filter pizza
    public function filter($id)
    {
        $pizza = Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));

    }

    //cart list
    public function cartList()
    {
        $cartList = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price', 'products.image as product_image')
            ->leftjoin('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->pizza_price * $c->qty;
        }

        return view('user.main.cart', compact('cartList', 'totalPrice'));

    }

    //direct pizzaDetails
    public function pizzaDetails($pizzaId)
    {
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details', compact('pizza', 'pizzaList'));
    }

    //user account change
    public function accountChange($id, Request $request)
    {
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        if ($request->hasfile('image')) {
            //old image name |check =>delete |store

            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        User::where('id', $id)->update($data);
        return back()->with(['updateSuccess' => 'account updated successfully']);

    }

    //history page
    public function history()
    {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate('5');
        return view('user.main.history', compact('order'));
    }

    //acc validation check
    private function accountValidationCheck($request)
    {
        validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,,webp,jpeg|file',
            'address' => 'required',
        ])->validate();
    }

    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];
    }

    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:7',
            'newPassword' => 'required|min:7',
            'confirmPassword' => 'required|min:7|same:newPassword',
        ])->validate();
    }

    //direct userList page
    public function userList()
    {
        $users = User::where('role', 'user')->paginate('3');
        return view('admin.user.list', compact('users'));
    }

    //change user role
    public function userChangeRole(Request $request)
    {
        $updateSource = [
            'role' => $request->role,
        ];
        User::where('id', $request->userId)->update($updateSource);
    }
    //direct contact page
    public function contactPage()
    {
        return view('user.contact.contactPage');
    }

    //get contact data
    public function contact(Request $request)
    {

        $data = $this->getUserMessage($request);
        $this->messageValidationCheck($request);
        Contact::create($data);
        return back()->with(['message' => 'Message Send Successfully']);
    }

    private function getUserMessage($request)
    {
        return [
            'name' => $request->userName,
            'email' => $request->userEmail,
            'message' => $request->message,
        ];
    }
    private function messageValidationCheck($request)
    {
        Validator::make($request->all(), [
            'userName' => 'required|min:2',
            'userEmail' => 'required|max:30',
            'message' => 'required|min:5',
        ])->validate();
    }
}