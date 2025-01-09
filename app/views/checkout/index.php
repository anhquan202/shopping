<?php $title = 'Checkout Page';
if (isset($carts['products'])) {
  $total_price = 0;
  foreach ($carts['products'] as $product) {
    $total_price += $product['quantity'] * $product['price_out'];
  }
}
?>
<form id="checkout">
  <div class="billing-details">
    <h2>Billing Details</h2>
    <div class="receiver-address">
      <h3>Receiver Address</h3>
      <div class="info-detail">
        <div class="identity">
          <span id="full_name" name="full_name"></span>
          <span id="user_phone" name="user_phone"></span>
          <span id="address" name="address"></span>
        </div>
        <a href="#" class="change-address">Thay đổi</a>
      </div>
      <div id="modal-overlay">
        <div id="modal">
          <h3>User Information</h3>
          <div class="info-user">
            <div class="form-group">
              <label for="full_name">Full Name *</label>
              <input type="text" id="full_name" placeholder="Full Name" class="input-field">
              <b class="error error-fullname"></b>
            </div>
            <div class="form-group">
              <label for="user_phone">Phone Number *</label>
              <input type="text" id="user_phone" placeholder="Phone Number" class="input-field">
              <b class="error error-phone"></b>
            </div>
          </div>
          <div class="form-group">
            <label for="address">Address*</label>
            <input type="text" id="address" class="input-field" placeholder="Receiver Address" required>
            <div id="suggestions-list" class="suggestions">
              <div class="options">
                <div id="province" class="btn-select active">Province</div>
                <div id="district" class="btn-select">District</div>
                <div id="ward" class="btn-select">Ward</div>
              </div>
              <ul class="list-address">

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="order-summary">
      <h2>Order Summary</h2>
      <table class="order-items">
        <thead>
          <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($carts['products'] as $product): ?>
            <tr class="item">
              <td><img src="/shopping/assets/images/<?= $product['primary_image'] ?>" alt="product-image"></td>
              <td><span><?= $product['name']; ?></span></td>
              <td><span class="price_out">
                  <?= number_format($product['price_out']); ?>
                </span></td>
              <td><span><?= $product['quantity']; ?></span></td>
              <td><span class="products-price" id="subtotal"><?= number_format($product['quantity'] * $product['price_out']); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="order-totals">
        <div class="total-amount">
          <strong class="amount" name="amount"><?= number_format($total_price); ?></strong>
        </div>
      </div>
      <input type="hidden" name="amount" value="<?= floatval($total_price); ?>">
    </div>

    <div class="payment-options">
      <h3>Payment Method</h3>
      <section class="options">
        <label for="atm">
          <input type="radio" name='payment_method' value="ATM" required>
          <img src="assets\icons\icon-vnpay.png" alt="VNPay" class="icon-payment">
        </label>
        <label for="delivered">
          <input type="radio" name='payment_method' value="delivered" required>
          Cash on delivery
        </label>
      </section>
    </div>

    <div class="purchase">
      <button type="submit" data-cart-id="<?= $carts['cart_id'] ?>" name="redirect" class="btn-purchase">Place Order</button>
    </div>
  </div>
</form>