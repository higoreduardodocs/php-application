<?php

include '../config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_GET['delete'])) {

  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `users` WHERE id = '$id'") or die('query failed');
  header('location:./users.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php include './header.php'; ?>

  <section class="users">
    <h1 class="title">Users accounts</h1>
    <div class="box-container">
      <?php
        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
        while($fetch_users = mysqli_fetch_assoc($select_users)) {
      ?>
      <div class="box">
        <p>User id: <span><?php echo $fetch_users['id']; ?></span></p>
        <p>Name: <span><?php echo $fetch_users['name']; ?></span></p>
        <p>Email: <span><?php echo $fetch_users['email']; ?></span></p>
        <p>User type: <span><?php echo $fetch_users['user_type']; ?></span></p>
        <a href="./users.php?delete=<?php echo $fetch_users['id']; ?>" class="btn red" onclick="return confirm('Delete this user?')">Delete</a>
      </div>
      <?php }; ?>
    </div>
  </section>

  <script src="../js/script.js"></script>
</body>
</html>