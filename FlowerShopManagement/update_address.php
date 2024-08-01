<?php

include 'includes/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   header('location:home.php');
   exit(); // Make sure to exit after redirect to stop further execution
}

if(isset($_POST['submit'])){
   $address = $_POST['flat'] .', '.$_POST['town'] .', '. $_POST['city'] .', - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   header('location:checkout.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Address</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'includes/user_header.php' ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Your Address</h3>
      <input type="text" class="box" placeholder="Street" required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="Town Name" required maxlength="50" name="town">
      <input type="text" class="box" placeholder="City Name" required maxlength="50" name="city">
      <input type="number" class="box" placeholder="Postal Code" required max="999999" min="0" maxlength="6" name="pin_code">
      <input type="submit" value="Save Address" name="submit" class="btn">
   </form>
</section>

<?php include 'includes/footer.php' ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
