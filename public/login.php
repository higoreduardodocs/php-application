<?php
include './config.php';
session_start();

if (isset($_POST['submit'])) {

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, md5($_POST['password']));
  $user_type = $_POST['user_type'];

  $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('query failed');

  if (mysqli_num_rows($select_users) > 0) {
    $row = mysqli_fetch_assoc($select_users);

    if ($row['user_type'] != $user_type) {
      $message[] = 'Incorrect credentials';
    } else {
      if ($row['user_type'] == 'admin') {
        $_SESSION['admin_name'] = $row['name'];
        $_SESSION['admin_email'] = $row['email'];
        $_SESSION['admin_id'] = $row['id'];
        header('location:admin/home.php');
      } else if ($row['user_type'] == 'user') {
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_id'] = $row['id'];
        header('location:index.php');
      }
    }
  } else {
    $message[] = 'Incorrect email or password';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
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
  <div class="form-container wrapper">
    <form action="" method="post">
      <h3>Login now</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box" />
      <input type="password" name="password" placeholder="Enter your password" required class="box" />
      <select name="user_type" class="box">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Login now" class="btn purple" />
      <p>Don't have an account? <a href="register.php">register now</a></p>
    </form>
  </div>
</body>
</html>