<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart extends Model
{
    use HasFactory;

    public static function getProducts(Request $request): array
    {
        if ($request->session()->missing('cart'))
        {
            $request->session()->put('cart', []);
            return [];
        } else {
            return $request->session()->get('cart');
        }
    }

    public static function getProductsIds(Request $request): array
    {
        $cart = self::getProducts($request);
        $ids = [];
        foreach ($cart as $cart_item)
        {
            $ids[] = $cart_item['product'];
        }
        return $ids;
    }

    public static function getProductCount(Request $request, Product $product): int
    {
        $cart = self::getProducts($request);
        foreach ($cart as $cart_item)
        {
            if ($cart_item['product'] == $product->id)
            {
                return $cart_item['count'];
            }

        }
        return 0;
    }

    public static function getProductsWithCount(Request $request): array
    {
        $cart_products_ids = self::getProductsIds($request);
        $products = Product::whereIn('id', $cart_products_ids)->get();
        $cart = [];

        foreach ($products as $product)
        {
            $cart[] = ['product' => $product, 'count' => self::getProductCount($request, $product)];
        }

        return $cart;
    }

    public static function addProduct(Request $request, Product $product): void
    {
        $cart = self::getProducts($request);

        self::clear($request);

        for($i = 0; $i < count($cart); $i++)
        {
            if ($cart[$i]['product'] == $product->id)
            {
                $product_pos = $i;
                break;
            }
        }

        if (isset($product_pos))
        {
            $cart[$product_pos]['count']++;
            $request->session()->put('cart', $cart);
            return;
        }

        $cart[] = ['product' => $product->id, 'count' => 1];

        $request->session()->put('cart', $cart);
    }

    public static function removeProduct(Request $request, Product $product): void
    {
        $cart = self::getProducts($request);

        self::clear($request);

        for($i = 0; $i < count($cart); $i++)
        {
            if ($cart[$i]['product'] == $product->id)
            {
                $product_pos = $i;
                break;
            }
        }

        if (isset($product_pos))
        {
            if ($cart[$product_pos]['count'] == 1)
            {
                unset($cart[$product_pos]);
                $cart = array_values($cart);
            } else {
                $cart[$product_pos]['count']--;
            }

            $request->session()->put('cart', $cart);
            return;
        }

        $request->session()->put('cart', $cart);
    }

    public static function getOverallCount(Request $request): int
    {
        $cart = self::getProducts($request);
        $count = 0;

        foreach ($cart as $item)
        {
            $count += $item['count'];
        }

        return $count;
    }

    public static function clear(Request $request)
    {
        $request->session()->forget('cart');
    }
}
