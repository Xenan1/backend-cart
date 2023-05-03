<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): view
    {
        $cart = Cart::getOverallCount($request);
        $products = Product::get();
        return view('products.index', compact('products', 'cart'));
    }

    public function store(Request $request, Product $product)
    {
        Cart::addProduct($request, $product);
        return redirect('/products/');
    }

}
