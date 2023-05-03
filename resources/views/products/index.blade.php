<?php ?>
<div>
    <a href="/cart/">Your cart</a>
    @if($cart)
        <span><?= $cart ?></span>
    @endif
</div>
@foreach($products as $product)
    <form method="post" action="/products/add_cart/<?= $product->id ?>">
        @csrf
        <div class="product-cart">
            <input name="product" type="hidden" value="<?= $product->id ?>">
            <button type="submit"><?= $product->name ?></button>
            <p class="product-cart__price"><?= $product->price . '$' ?></p>
            <img src="<?= $product->image ?>" alt="product_image">
        </div>
    </form>

@endforeach
