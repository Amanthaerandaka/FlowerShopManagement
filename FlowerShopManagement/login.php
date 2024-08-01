<?php

include 'includes/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

$message = []; // Initialize $message as an array

if(isset($_POST['submit'])){
   
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitize email
   $pass = sha1($_POST['pass']); // Hash the password
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); // Sanitize the hashed password

   // Prepare and execute SQL query
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      
      // JavaScript alert for login success and redirect
      echo '<script>
               alert("Login successful!");
               window.location.href = "home.php";
            </script>';
      exit();
   } else {
      // Add message to array
      $message[] = 'Incorrect username or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'includes/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container"> 

   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
      <p>For <a href="admin/admin_login.php"> Admin login </a></p>
   </form>

   <?php if(!empty($message) && is_array($message)): ?>
      <div class="message">
         <?php foreach($message as $msg): ?>
            <p><?= htmlspecialchars($msg); ?></p>
         <?php endforeach; ?>
      </div>
   <?php endif; ?>

</section>

<?php include 'includes/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
