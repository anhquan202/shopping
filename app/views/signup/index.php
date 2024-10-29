<?php $title = "Signup Page" ?>

<section id="signup">
  <img src="/shopping/assets/images/background-auth.png" alt="background-auth" class="background-auth">
  <div class="auth-container">
    <div class="heading">
      <p>Sign up to Exclusive</p>
    </div>
    <form id="signup-form" method="post">
      <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" placeholder="Full Name" class="input-field" required>
        <span></span>
      </div>
      <div class="form-group">
        <label for="user_phone">Phone Number</label>
        <input type="text" placeholder="Phone Number" class="input-field" required>
        <span></span>
      </div>
      <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" placeholder="Email" class="input-field">
        <span></span>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" placeholder="Password" class="input-field" required>
        <span></span>
      </div>
      <div class="form-group">
        <label for="repeat-password">Repeat Password</label>
        <input type="password" placeholder="Repeat Password" class="input-field" required>
        <span></span>
      </div>
      <div class="actions">
        <button type="submit" class="btn-signup">Sign Up</button>
      </div>
    </form>
    <div class="oauth-actions">
      <span>Or Signup With</span>
      <div class="oauth-buttons">
        <button class="btn-google">
          <img src="/shopping/assets/logo/Logo-google-icon-PNG.png" alt="Google logo" class="icon-auth">
          <span>Google</span>
        </button>
        <button class="btn-facebook">
          <img src="/shopping/assets/logo/facebook.png" alt="Facebook logo" class="icon-auth">
          <span>Facebook</span>
        </button>
      </div>
    </div>
    <div class="redirect-login">
      <span>Do you have an account?</span>
      <a href="login">Login</a>
    </div>
  </div>
</section>