<?php $title = 'Checkout Page' ?>
<form id="checkout">
  <div class="billing-details">
    <h2>Billing Details</h2>
    <div class="info-user">
      <div class="form-group">
        <label for="full_name">Full Name *</label>
        <input type="text" id="full_name" name="full_name" class="input-field" placeholder="Full Name" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number*</label>
        <input type="tel" id="phone" name="phone" class="input-field" placeholder="Phone" required>
      </div>

      <div class="form-group">
        <label for="address">Address*</label>
        <input type="text" id="address" name="address" class="input-field" placeholder="Receiver Address" required>
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


      <div>
        <input type="checkbox" id="save-info" name="save-info">
        <label for="save-info">Save this information for faster check-out next time</label>
      </div>
    </div>
  </div>

  <div class="order-summary">
    <h2>Order Summary</h2>
    <div class="order-items">
      <div class="item">
        <img src="assets\images\Headphone\bluetooth-airpods-2-apple-mv7n2-imei-ava.jpg" alt="LCD Monitor">
        <span class="name">LCD Monitor</span>
        <span class="price_out">$650</span>
      </div>
      <div class="item">
        <img src="assets\images\Headphone\bluetooth-airpods-2-apple-mv7n2-imei-ava.jpg" alt="HI Gamepad">
        <span class="name">HI Gamepad</span>
        <span class="price_out">$1100</span>
      </div>
    </div>

    <div class="order-totals">
      <div class="subtotal">
        <span>Subtotal:</span>
        <span>$1750</span>
      </div>
      <div class="shipping-cost">
        <span>Shipping:Free</span>
      </div>
      <div class="total-amount">
        <strong>Total: $1750</strong>
      </div>
    </div>

    <div class="payment-options">
      <label for="">
        <input type="radio" name="payment-method" value="vnpay" required>
        <img src="assets\icons\icon-vnpay.png" alt="VNPay" class="icon-payment">
      </label>
      <label for="">
        <input type="radio" name="payment-method" value="cod" required>
        Cash on delivery
      </label>
    </div>

    <button type="submit">Place Order</button>
  </div>
</form>