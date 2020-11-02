<?php

namespace App\Http\Controllers;


use App\Sale;
use Illuminate\Http\Request;


use App\Http\Requests;
use \Cart as Cart;
use Validator;

class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shop.cart');
    }

    public function proceed()
    {

        return view('shop.proceed');
    }








    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInfo($id)
    {
        $fill = \DB::table('stocks')->where('id', $id)->pluck('category_id');

        return Response::json(['success'=>true, 'info'=>$fill]);
    }



    public function store(Request $request)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if (!$duplicates->isEmpty()) {
            return redirect('shop-management')->withSuccessMessage('Item is already in your cart!');
        }

        Cart::add($request->id, $request->name, 1, $request->unit_price)->associate('App\Stock');
        return redirect('shop-management')->withSuccessMessage('Item was added to your cart!');
    }

//    public function storeCart(Request $request)
//    {
//        $cart_items = $request['group'];
//
//        for ($i = 0; $i < count($cart_items); $i++) {
//
//            Sale::insert([
//                'terminal_id' => $request['terminal_id'],
//                'customer_name' => $request['customer_name'],
//                 'unit_price' => $request['price'],
//                'total_price' => $request['subtotal'],
//                'tax' => $request['tax'],
//                'quantity' => $request['quantity'],
//                'product_name' => $request['product_name'],
//                'sale_date' => $request['sale_date'],
//                'rowId' => $request['rowId']
//            ]);
//        }
////        return redirect('cart');
//        return "God Win";
//    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validation on max quantity
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,100'
        ]);

        if ($validator->fails()) {
            session()->flash('error_message', 'Quantity must be between 1 and 100.');
            return response()->json(['success' => false]);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Quantity was updated successfully!');

        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return redirect('cart')->withSuccessMessage('Item has been removed!');
    }

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function emptyCart()
    {
        Cart::destroy();
        return redirect('cart')->withSuccessMessage('Your cart has been cleared!');
    }




    /**
     * Switch item from shopping cart to wishlist.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToWishlist($id)
    {
        $item = Cart::get($id);

        Cart::remove($id);

        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });

        if (!$duplicates->isEmpty()) {
            return redirect('cart')->withSuccessMessage('Item is already in your Wishlist!');
        }

        Cart::instance('wishlist')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Stock');

        return redirect('cart')->withSuccessMessage('Item has been moved to your Wishlist!');

    }
}
