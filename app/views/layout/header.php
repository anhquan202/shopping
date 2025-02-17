<header id="header">
  <div id="header-content">
    <nav class="main-nav">
      <a href="/shopping" class="logo">
        <img src="/shopping/assets/images/Exclusive.png" alt="" srcset="">
      </a>
      <ul class="nav">
        <li class="nav-item"><a href="/shopping" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="" class="nav-link">Contact</a></li>
        <li class="nav-item"><a href="" class="nav-link">About</a></li>
        <li class="nav-item"><a href="signup" class="nav-link">Sign Up</a></li>
      </ul>
    </nav>

    <div class="actions">
      <form action="" method="post" id="search">
        <input type="text" placeholder="What are you looking for?" />
        <img src="/shopping/assets/icons/icon-search.svg" alt="" srcset="">
      </form>

      <!-- handle show/hide actions ui -->
      <?php
      $path = isset($_SESSION['current_path']) ? $_SESSION['current_path'] : '';

      $hiddenPaths = ['signup', 'login'];
      if (in_array($path, $hiddenPaths)) {
        echo '';
      } else {
      ?>
        <div class="carts">
          <a class="counter">
            <img src="/shopping/assets/icons/icon-wishlist.svg" alt="" srcset="">
            <div class="cart-icon">
              <p class="cart-item-count" id="wishlist">0</p>
            </div>
          </a>
          <a href="cart" class="counter">
            <img src="/shopping/assets/icons/icon-cart.svg" alt="" srcset="">
            <div class="cart-icon">
              <p class="cart-item-count" id="shopping-cart">0</p>
            </div>
          </a>
          <a class="redirect-login" style="display: flex; align-items: flex-start; text-decoration: none; color: #000;" href="login">
            <img src="/shopping/assets/icons/icon-user.svg" alt="" srcset="">
            Login
          </a>
          <div class="user-info">
            <div class="user-display">
              <img id="user-icon" src="/shopping/assets/icons/icon-user.svg" alt="">
              <span class="user-name"></span>
            </div>
            <div class="user-dropdown">
              <a href="#">Profile</a>
              <a href="" id="logout">Logout</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</header>