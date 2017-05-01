<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="font-awesome-4.6.3\css\font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="bootstrap/dist/css/o-style.css" type="text/css" />
    <link rel="stylesheet" href="bootstrap/dist/css/c-style.css" type="text/css" />
    <link rel="stylesheet" href="bootstrap/dist/css/shop.css" type="text/css" />
    <link rel="stylesheet" href="bootstrap/dist/css/product-info.css" type="text/css" />
    <link rel="stylesheet" href="owl.carousel/owl-carousel/owl.carousel.custom.css">
    <link rel="stylesheet" href="owl.carousel/owl-carousel/owl.theme.css">
    <link rel="stylesheet" href="bootstrap/dist/css/cart-items.css" type="text/css" />
    <link rel="stylesheet" href="fresco-2.2.2-light/css/fresco/fresco.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/dist/css/reg_form.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/dist/css/checkout.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/dist/css/orders.css" type="text/css">
    <style type="text/css">
    /* This only works with JavaScript,
    if it's not present, don't show loader */
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
    	position: fixed;
    	left: 0px;
    	top: 0px;
    	width: 100%;
    	height: 100%;
    	z-index: 9999;
    	background: url(images/loader-64x/Preloader_2.gif) center no-repeat #fff;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
    <script src="bootstrap/dist/js/jquery.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="owl.carousel/owl-carousel/owl.carousel.custom.js"></script>
    <script src="bootstrap/dist/js/scrollnav.js"></script><!-- (Fixed nav on scrolling) -->
    <script src="bootstrap/dist/js/slider.js"></script>
    <script src="bootstrap/dist/js/product-slider.js"></script>
    <script src="bootstrap/dist/js/side-nav.js"></script>
    <script src="fresco-2.2.2-light/js/fresco/fresco.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>  <!-- For feature detection and here it is used for page preloader -->

    <script type="text/javascript">
    	// Wait for window load
    	$(window).on('load',function() {
    		// Animate loader off screen
    		$(".se-pre-con").fadeOut("slow");
    	});
    </script>
    <script type="text/javascript">
    //Setting menu icon to logout to login and vice versa (used in user_menu_set.js)
    var user_logged_in = <?php if(isset($_SESSION['user_id'])){
                                                              echo true;}else{
                                                                echo 0;
                                                              }

                          ?>;
    //Used in cart_count.js
    var cart_count = '<?php echo get_order_count();?>';
    </script>

    <title>The Collection - Ombre.com</title>
</head>
<body>
<!--Preloader start -->
<div class="se-pre-con"></div>
<!--Preloader end -->
<div class="page-wrap">   <!-- Div which conatins all the content except footer div closes in footer.php (used only to make footer sticky) -->

<!--Side nav-->

<?php require_once(TEMPLATE_FRONT.DS."side_nav.php"); ?>

<!-- header -->

<div class="container-fluid header">       <!---Header container start -->

  <!-- BLACK STRIP-->

<?php require_once(TEMPLATE_FRONT.DS."top_black_strip.php"); ?>

    <!--LOGO-->

<?php require_once(TEMPLATE_FRONT.DS."logo.php"); ?>

    <!-- Navigation menu -->

<?php require_once(TEMPLATE_FRONT.DS."top_nav.php"); ?>

</div>      <!---Header container end -->
