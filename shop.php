<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>

<!--header ENDS-->

<div class="container">     <!--Content (cards) container start -->

  <!---Sub heading -->

  <div class="row">   <!---row start -->
      <div class="col-md-12 text-center sub-headings">
          <p>All Products</p>
      </div>
  </div>    <!---row end -->

  <!---CARDS -->

  <div class="row">   <!---row start -->

      <div class="col-md-12 all-padding-zero">      <!---Main column start -->

        <!---Products -->
            <?php get_all_products_in_shop(); ?>
        </div>      <!---Main column end -->

    </div>    <!---row end -->

</div>     <!--Content (cards) container ends -->

<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>


</body>
</html>
