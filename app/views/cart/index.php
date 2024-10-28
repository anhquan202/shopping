<?php
$title = 'Your Cart';
?>
<section class="my-carts">
  <ul class="heading-title">
    <li>Product</li>
    <li>Price</li>
    <li>Quantity</li>
    <li>Purchase</li>
    <li>Actions</li>
  </ul>
  <form method="post" id="buy-products">
    <div class="list-item">
      <?php foreach ($cartItem as $product): ?>
        <div class="item" id="product-<?= $product['product_id']; ?>">
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
          <span class="products-price"><?= number_format($product['quantity'] * $product['price_out']); ?></span>
          <button class="btn-remove">Remove</button>
        </div>
      <?php endforeach ?>
    </div>
    <div class="payment">
      <span class="purchase-final"></span>
      <button class="btn-buy">
        Buy Products
      </button>
    </div>
  </form>
</section>