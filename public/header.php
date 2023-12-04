<header class="header">
  <?php
    $user_id = $_SESSION['user_id'];
    if (isset($message)) {
      foreach($message as $msg) {
        echo '
        <div class="message">
          <span>'.$msg.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
      }
    }
  ?>
  <div class="header-top">
    <div>
      <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-linkedin"></a>
      </div>
      <div class="auth">
        <a href="./login.php">Login</a>
        <a href="./register.php">Register</a>
      </div>
    </div>
  </div>
  <div class="header-bottom">
    <div>
      <a href="./index.php" class="logo">Bookly.</a>
      <nav class="navbar">
        <a href="./index.php">Home</a>
        <a href="./about.php">About</a>
        <a href="./shop.php">Shop</a>
        <a href="./contact.php">Contact</a>
        <a href="./orders.php">Orders</a>
      </nav>
      <div class="icons">
        <i id="menu-btn" class="fas fa-bars"></i>
        <a href="./search.php"><i class="fas fa-search"></i></a>
        <i id="account-btn" class="fas fa-users"></i>
        <?php
          $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
          $cart_rows_number = mysqli_num_rows($select_cart_number); 
        ?>
        <a href="./cart.php">
          <i class="fas fa-shopping-cart"></i>
          <span>(<?php echo $cart_rows_number; ?>)</span>
        </a>
      </div>
      <div class="account-box">
        <p>User: <span><?php echo $_SESSION['user_name']; ?></span></p>
        <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
        <a href="./logout.php" class="btn red">Logout</a>
      </div>
    </div>
  </div>
</header>