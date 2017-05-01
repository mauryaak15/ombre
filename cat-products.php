<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>


<!--header ENDS-->

<div class="container">     <!--Content (cards) container start -->

  <!---Sub heading -->

  <div class="row">   <!---row start -->
      <div class="col-md-12 text-center">
          <h1>Shop By Category <small>
            <?php
            if(isset($_GET['id'])&&!empty($_GET['id'])){
              $cat_id = escape_string($_GET['id']);
              $query = query("SELECT cat_title FROM categories WHERE cat_id={$cat_id}");
              if($query){
                while($row=fetch_array($query)){
                  echo $row['cat_title'];
                }
              }else{
                echo 'problem in fetching category name';
              }
            }else {
              echo 'problem in fetching category name';
            }
            ?>
          </small></h1></p>
      </div>
  </div>    <!---row end -->

  <!---CARDS -->

  <div class="row">   <!---row start -->

      <div class="col-md-12 all-padding-zero">      <!---Main column start -->

        <!---Products card  -->

        <?php get_cat_products(); ?>

        </div>      <!---Main column end -->

    </div>    <!---row end -->

</div>     <!--Content (cards) container ends -->

<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>


</body>
</html>
