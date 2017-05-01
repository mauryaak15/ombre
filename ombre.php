<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>

<!--header ENDS-->


<div class="container main">     <!---Slider And Content (cards) container start -->

<h1 class="cart_empty_message text-center text-danger bg-danger"><?php display_message();?></h1>
<?php require_once(TEMPLATE_FRONT.DS."slider.php"); ?>

    <hr>

    <!---Sub heading -->

    <div class="row">   <!---row start -->
        <div class="col-md-12 text-center sub-headings">
            <p>Our Speciality</p>
        </div>
    </div>    <!---row end -->

    <!---CARDS -->

    <div class="row">   <!---row start -->

        <div class="col-md-12 all-padding-zero">      <!---Main column start -->

          <!---Speciality card 1 -->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="card-main-cont">
                    <img src="images/special.png" alt="Dr. XYZ" class="avatar">
                    <div class="card-txt-cont">
                        <h4>
                            Tailored Fit
                        </h4>
                        <p>Description</p>
                    </div>
                </div>
            </div>

            <!---Speciality card 2 -->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="card-main-cont">
                    <img src="images/special.png" alt="Dr. XYZ" class="avatar">
                    <div class="card-txt-cont">
                        <h4>
                            Tailored Fit
                        </h4>
                        <p>Description</p>
                    </div>
                </div>
            </div>

            <!---Speciality card 3 -->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="card-main-cont">
                    <img src="images/special.png" alt="Dr. XYZ" class="avatar">
                    <div class="card-txt-cont">
                        <h4>
                            Tailored Fit
                        </h4>
                        <p>Description</p>
                    </div>
                </div>
            </div>

            <!---Speciality card 4 -->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="card-main-cont">
                    <img src="images/special.png" alt="Dr. XYZ" class="avatar">
                    <div class="card-txt-cont">
                        <h4>
                            Tailored Fit
                        </h4>
                        <p>Description</p>
                    </div>
                </div>
            </div>

        </div>      <!---Main column end -->

    </div>    <!---row end -->

    <hr>

    <!---Sub heading -->

    <div class="row">   <!---row start -->
        <div class="col-md-12 text-center sub-headings">
            <p>Shop By Category</p>
        </div>
    </div>    <!---row end -->

    <!-- CARDS -->

    <div class="row">   <!---row start -->

        <div class="col-md-12 all-padding-zero">    <!---Main column start -->

          <!-- categories cards -->

          <?php get_4_categories(); ?>


        </div>    <!---Main column end -->

    </div>    <!---row end -->

    <!---Button -->

    <div class="row">   <!---row start -->
        <div class="col-md-12 all-padding-zero text-center">
            <a class="btn btn-primary btn-more" href="categories.php">Explore ></a>
        </div>
    </div>    <!---row end -->

    <hr>

    <!---Sub heading -->

    <div class="row">   <!---row start -->
        <div class="col-md-12 text-center sub-headings">
            <p>All Products</p>
        </div>
    </div>    <!---row end -->

    <!---All Product Slider -->

    <div class="row">   <!---row start -->

        <div id="product-slider" class="owl-carousel owl-theme marg-bot-up">      <!---Main column start -->

        <!---Products  -->

        <?php get_products_in_slider(); ?>

        </div>      <!---Main column end -->

      </div>    <!---row end -->

    <!---Button -->

    <div class="row">   <!---row start -->
        <div class="col-md-12 all-padding-zero text-center" style="margin-top: -30px;">
            <a class="btn btn-primary btn-more" href="shop.php">Explore ></a>
        </div>
    </div>    <!---row end -->

    <hr>

    <!-- BENIFITS (Shipping, COD, Return etc) -->

    <div class="row">   <!---Row start -->

        <div class="col-md-12 benifits all-padding-zero">     <!-- Main column start -->

          <!-- Benifit 1-->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="benifits-shipping text-center">
                    <img alt="Free shipping" src="images/shipping.png">
                    <br>
                    <h3>Free shipping*</h3>
                    <p>hjdbwbj</p>
                </div>
            </div>

            <!-- Benifit 2-->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="benifits-contact_us text-center">
                    <img alt="contact us" src="images/contact_us.png">
                    <br>
                    <h3>Contact us</h3>
                    <p>hjdbwbj</p>
                </div>
            </div>

            <!-- Benifit 3-->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class="benifits-return text-center">
                    <img alt="Return" src="images/return_product.png">
                    <br>
                    <h3>Return</h3>
                    <p>hjdbwbj</p>
                </div>
            </div>

            <!-- Benifit 4-->

            <div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
                <div class=" benifits-cod text-center">
                    <img alt="COD" src="images/cod.png">
                    <br>
                    <h3>Cash on delivery</h3>
                    <p>hjdbwbj</p>
                </div>
            </div>

        </div>      <!-- Main column end -->

    </div>    <!---Row end -->

    <hr>
</div>      <!---Slider And Content (cards) container end -->


<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

</body>
</html>
