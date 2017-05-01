<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>

<!--header ENDS-->

<div class="container">     <!--Content (cards) container start -->

  <!---Sub heading -->

  <div class="row">   <!---row start -->
      <div class="col-md-12 text-center sub-headings">
          <p>Our Products</p>
      </div>
  </div>    <!---row end -->

  <!---CARDS -->

  <div class="row">   <!---row start -->

      <div class="col-md-12 all-padding-zero">      <!---Main column start -->

        <!-- Categories cards  -->

        <?php get_all_categories() ?>

        </div>      <!---Main column end -->

    </div>    <!---row end -->

</div>     <!--Content (cards) container end-->

<!-- FOOTER -->


<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>


</body>
</html>
