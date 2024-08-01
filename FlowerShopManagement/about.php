<?php

include 'includes/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'includes/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>about us</h3>
   <p><a href="home.php">Home</a> <span> / About</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-us.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Here’s why our flower shop stands out:</p>
         <p><strong>Fresh Flowers Daily </strong></p>
         <p><strong>Unique Arrangements</strong></p>
         <p><strong>Personalized Service</strong></p>
         <p><strong>Competitive Prices</strong></p>
         <p><strong>Experienced Florists</strong></p>
         <p><strong>Reliable Delivery</strong></p>
         <p><strong>Exceptional Customer Care</strong></p>
         <p>Brighten your day with our beautiful flowers. Explore our collection today!</p>
         <a href="menu.php" class="btn">our products</a>
      </div>
      
   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/choose-order.webp" alt="">
         <h3>choose order</h3>
         
      </div>

      <div class="box">
         <img src="images/fast-delivery.webp" alt="">
         <h3>fast delivery</h3>
         
      </div>

      <div class="box">
         <img src="images/enjoy.webp" alt="">
         <h3>enjoy our service</h3>
         
      </div>

   </div>

</section>




<!-- footer section starts  -->
<?php include 'includes/footer.php'; ?>
<!-- footer section ends -->

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>