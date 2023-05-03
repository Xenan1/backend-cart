<?php ?>
<a href="/products/">To products list</a>
<a href="/cart/clear/">Clear cart</a>

<div>
    <span>Your cart</span>
        <span><?= $cart_count ?></span>
</div>
@foreach($cart_products as $product)
    <form method="post" action="/cart/remove_cart/<?= $product['product']->id ?>">
        @csrf
        <div class="product-cart">
            <input name="product" type="hidden" value="<?= $product['product']->id ?>">
            <button type="submit"><?= $product['product']->name . ' x' . $product['count'] ?></button>
            <p class="product-cart__price"><?= $product['product']->price . '$' ?></p>
            <img src="<?= $product['product']->image ?>" alt="product_image">
        </div>
    </form>

@endforeach
