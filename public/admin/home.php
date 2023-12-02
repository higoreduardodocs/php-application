<?php

include '../config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php include './header.php'; ?>
  
  <section class="dashboard">
    <div class="box-container">
      <div class="box">
        <?php
          $total_pendings = 0;
          $select_pendings = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
          if (mysqli_num_rows($select_pendings) > 0) {
            while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
              $total_pendings += $fetch_pendings['total_price'];
            }
          }
        ?>
        <h3>$<?php echo $total_pendings; ?></h3>
        <p>Total pendings</p>
      </div>

      <div class="box">
      <?php
          $total_completed = 0;
          $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
          if (mysqli_num_rows($select_completed) > 0) {
            while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
              $total_completed += $fetch_completed['total_price'];
            }
          }
        ?>
        <h3>$<?php echo $total_completed; ?></h3>
        <p>Completed payments</p>
      </div>

      <div class="box">
        <?php
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
          $number_of_orders = mysqli_num_rows($select_orders);
        ?>
        <h3><?php echo $number_of_orders; ?></h3>
        <p>Order placed</p>
      </div>
  
      <div class="box">
        <?php
          $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
          $number_of_products = mysqli_num_rows($select_products);
        ?>
        <h3><?php echo $number_of_products; ?></h3>
        <p>Products added</p>
      </div>

      <div class="box">
        <?php
          $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
          $number_of_users = mysqli_num_rows($select_users);
        ?>
        <h3><?php echo $number_of_users; ?></h3>
        <p>Users</p>
      </div>

      <div class="box">
        <?php
          $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
          $number_of_admin = mysqli_num_rows($select_admin);
        ?>
        <h3><?php echo $number_of_admin; ?></h3>
        <p>Admin</p>
      </div>

      <div class="box">
        <h3><?php echo $number_of_users + $number_of_admin; ?></h3>
        <p>Total accounts</p>
      </div>

      <div class="box">
        <?php
          $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
          $number_of_message = mysqli_num_rows($select_message);
        ?>
        <h3><?php echo $number_of_message; ?></h3>
        <p>New messages</p>
      </div>
    </div>
  </section>

  <script src="../js/script.js"></script>
</body>
</html>