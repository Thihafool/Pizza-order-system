<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return pizza list

    public function pizzaList(Request $request)
    {

        logger($request->all());

        if ($request->status == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        }
        if ($request->status == 'asc') {
            $data = Product::orderBy('created_at', 'asc')->get();
        }
        // return $pizza;
        return response()->json($data, 200);

    }
    //order
    public function order(Request $request)
    {
        $total = 0;
        foreach ($request->all() as $item) {
            $data = OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code'],
            ]);

            $total += $data->total;
        }
        Cart::where('user_id', Auth::user()->id)->delete();
        // logger($data);
        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total + 3000,
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'order complete',
        ], 200);
    }

    //add to cart
    public function addToCart(Request $request)
    {

        $data = $this->getOrderData($request);
        Cart::create($data);

        $response = [
            'message' => 'Add To Card Complete',
            'status' => 'success',
        ];

        return response()->json($response, 200);
    }
    ///get orderData
    private function getOrderData($request)
    {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    //clear cart
    public function clearCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    //clear current product
    public function clearCurrentProduct(Request $request)
    {
        // logger($request->all());
        Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request->productId)
            ->where('id', $request->orderId)
            ->delete();
    }

    //increase pizza view count
    public function increaseViewCont(Request $request)
    {
        $pizza = Product::where('id', $request->productId)->first();
        $viewCount = [
            'view_count' => $pizza->view_count + 1,
        ];
        Product::where('id', $request->productId)->update($viewCount);
    }
}