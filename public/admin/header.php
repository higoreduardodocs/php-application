<header class="admin-header">
  <?php
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
  <div>
    <a href="./home.php" class="logo">Admin <span>Panel</span></a>

    <nav class="navbar">
      <a href="./home.php">Home</a>
      <a href="./products.php">Products</a>
      <a href="./orders.php">Oders</a>
      <a href="./users.php">Users</a>
      <a href="./messages.php">Messages</a>
    </nav>

    <div class="icons">
      <i id="menu-btn" class="fas fa-bars"></i>
      <i id="account-btn" class="fas fa-users"></i>
    </div>

    <div class="account-box">
      <p>User: <span><?php echo $_SESSION['admin_name']; ?></span></p>
      <p>Email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
      <a href="../logout.php" class="btn red">Logout</a>
    </div>
  </div>
</header>