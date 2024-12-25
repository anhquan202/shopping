<?php
$title = 'Your Cart';
?>
<?php if (isset($carts) && count($carts) > 0): ?>
  <section class="my-carts">
    <ul class="heading-title">
      <li>Product</li>
      <li>Price</li>
      <li>Quantity</li>
      <li>Purchase</li>
      <li>Actions</li>
    </ul>
    <section id="carts" data-cart-id="<?= $carts['cart_id']; ?>">
      <div class="list-item">
        <?php foreach ($carts['products'] as $product): ?>
          <div class="item" id="product-<?= $product['product_id']; ?>" name="product_id">
            <div class="name">
              <img src="/shopping/assets/images/<?= $product['primary_image'] ?>" alt="product-image">
              <span><?= $product['name']; ?></span>
            </div>
            <span class="price_out">
              <?= number_format($product['price_out']); ?>
            </span>
            <div class="quantity-buy">
              <div class="quantity-input">
                <button class="btn-update btn-minus" data-product-id="<?= $product['product_id']; ?>">
                  <img src="/shopping/assets/icons/minus-solid.svg" alt="">
                </button>
                <input type="number" class="quantity" name="quantity" value="<?= $product['quantity']; ?>" min="1" max="<?= $product['stock'] ?>" step="1">
                <button class="btn-update btn-plus" data-product-id="<?= $product['product_id']; ?>">
                  <img src="/shopping/assets/icons/plus-solid.svg" alt="">
                </button>
              </div>
            </div>
            <span class="products-price" name="subtotal"><?= number_format($product['quantity'] * $product['price_out']); ?></span>
            <button class="btn-remove" data-product-id="<?= $product['product_id']; ?>">Remove</button>
          </div>
        <?php endforeach ?>
      </div>
      <div class="payment">
        <span class="purchase-final" name="total_amount"></span>
        <a href="checkout" class="btn-buy">
          Buy Products
        </a>
      </div>
    </section>
  </section>
<?php else: ?>
  <p>Your cart is empty. Add items to start shopping!</p>
<?php endif; ?>