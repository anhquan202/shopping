<?php $title = "Signup Page" ?>

<section id="signup">
  <img src="/shopping/assets/images/background-auth.png" alt="background-auth" class="background-auth">
  <div class="auth-container">
    <div class="heading">
      <p>Sign up to Exclusive</p>
    </div>
    <form id="signup-form" method="post">
      <div class="form-group">
        <label for="full_name">Full Name *</label>
        <input type="text" id="full_name" placeholder="Full Name" class="input-field" required>
        <b class="error error-fullname"></b>
      </div>
      <div class="form-group">
        <label for="user_phone">Phone Number *</label>
        <input type="text" id="user_phone" placeholder="Phone Number" class="input-field" required>
        <b class="error error-phone"></b>
      </div>
      <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" placeholder="Email" class="input-field">
      </div>
      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" placeholder="Password" class="input-field" required>
        <b class="error error-password"></b>
      </div>
      <div class="form-group">
        <label for="repeat-password">Repeat Password *</label>
        <input type="password" id="repeat-password" placeholder="Repeat Password" class="input-field" required>
        <b class="error error-repeat-password"></b>
      </div>
      <div class="actions">
        <button type="submit" class="btn-signup">Sign Up</button>
      </div>
    </form>
    <div class="redirect-login">
      <span>Do you have an account?</span>
      <a href="login">Login</a>
    </div>
  </div>
</section>