<div class="overview-product">
  <div class="image-info">
    <img src="/shopping/assets/images/<?= $productById['primary_image'] ?>" alt=" Main product image" class="image-main">
  </div>

  <div class="summary-info">
    <h1 class="name"><?= ucfirst($productById['name']) ?></h1>
    <div class="price">
      <span>Cost </span>
      <span><?= number_format($productById['price_out']) . ' vnđ' ?></span>
    </div>

    <div class="quantity-product">
      <span class="title">Quantity</span>
      <div class="quantity-input">
        <button class="btn-update btn-minus">
          <img src="/shopping/assets/icons/minus-solid.svg" alt="">
        </button>
        <input type="number" class="quantity" name="quantity" value="1" min="1" max="<?= $productById['stock'] ?>" step="1">
        <button class="btn-update btn-plus">
          <img src="/shopping/assets/icons/plus-solid.svg" alt="">
        </button>
      </div>
      <span class="stock"><?= $productById['stock'] . ' Valid Products' ?></span>
    </div>
    <div class="actions">
      <button class="btn btn_add-to-cart" data-product-id="<?= $productById['product_id'] ?>">Add to Cart</button>
      <button class="btn btn_buy">Buy Now</button>
    </div>
  </div>
</div>