<?php $title = "Login Page" ?>

<section id="login">
  <img src="/shopping/assets/images/background-auth.png" alt="background-auth" class="background-auth">
  <div class="auth-container">
    <div class="heading">
      <p>Log in to Exclusive</p>
    </div>
    <form id="login-form">
      <div class="error-login" style="color: #DB4444; font-weight: 600"></div>
      <div class="form-group">
        <label for="user_phone">Phone Number *</label>
        <input type="text" id="user_phone" name="user_phone" placeholder="Phone Number" class="input-field" required>
        <b class="error error-phone"></b>
      </div>
      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" placeholder="Password" class="input-field" required>
        <b class="error error-password"></b>
      </div>
      <div class="actions">
        <button class="btn-login">Log In</button>
        <a href="#" class="forgot-password">Forget Password?</a>
      </div>
    </form>
    <div class="oauth-actions">
      <span>Or Login With</span>
      <div class="oauth-buttons">
        <a href="login/redirect-google" class="btn-google">
          <img src="/shopping/assets/logo/Logo-google-icon-PNG.png" alt="Google logo" class="icon-auth">
          <span>Google</span>
        </a>
        <a class="btn-facebook">
          <img src="/shopping/assets/logo/facebook.png" alt="Facebook logo" class="icon-auth">
          <span>Facebook</span>
        </a>
      </div>
    </div>
    <div class="redirect-signup">
      <span>Don't have an account?</span>
      <a href="signup">Signup</a>
    </div>
  </div>
</section>