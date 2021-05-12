<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add($id)
    {
        $product = Product::findOrFail($id);

        // add the product to cart
        \Cart::session(auth()->id())->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $product
        ));

        return redirect()->route('cart.index');

    }
    public function index (){
        $cartItem = \Cart::session(auth()->id())->getContent();
        return view('cart.index', compact('cartItem'));
    }
    public function destroy($id){
        \Cart::session(auth()->id())->remove($id);
        return back();
    }
    public function addQuantity($id){
        \Cart::session(auth()->id())->update($id, [
            'quantity' => array(
                'relative' => false,
                'value' => \request()->quantity
            ),
        ]);
        return back();
    }
    public function checkout(){
        return view('cart.checkout');
    }
}
