<?php
$title = 'Complete Profile';
?>

<section class="complete-profile">
  <p class="heading">Complete Profile</p>
  <div class="form-group">
    <label for="full_name">Full Name *</label>
    <input type="text" id="full_name" placeholder="Full Name" class="input-field" value="<?php echo $data['full_name'] ?>">
    <b class="error error-fullname"></b>
  </div>
  <div class="form-group">
    <label for="user_phone">Phone Number *</label>
    <input type="text" id="user_phone" placeholder="Phone Number" class="input-field">
    <b class="error error-phone"></b>
  </div>
  <div class="form-group">
    <label for="user_phone">Email</label>
    <input type="text" id="user_email" name="user_email" disabled class="input-field" value="<?php echo $data['user_email'] ?>">
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
  <button type="submit" class="btn-save">Save User Information</button>
</section>