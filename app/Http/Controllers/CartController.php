<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): view
    {
        $cart_products = Cart::getProductsWithCount($request);
        $cart_count = Cart::getOverallCount($request);

        return view('cart.index', compact('cart_products', 'cart_count'));
    }

    public function delete(Request $request, Product $product)
    {
        Cart::removeProduct($request, $product);

        return redirect('/cart/');
    }

    public function clear(Request $request)
    {
        Cart::clear($request);
        return redirect('/products/');
    }
}
