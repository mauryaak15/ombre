<?php
//To stop direct access of this page from direct url
if (session_status() == PHP_SESSION_NONE) {
    session_start(); //To stop notice, session already started when this page is loaded from index of admin
}
if(!isset($_SESSION['admin_id'])){
  $_SESSION['message'] = "Invalid Request";
  header("Location: ../../../ombre.php");
  die();
}

?>

<div class="row">

  <div class="col-md-12">
      <div class="alert alert-success alert-dismissible fade in response_msg" style="display:none;">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <h2 class="text-center"></h2>
      </div>
      <h2 class="bg-success text-success text-center"><?php display_message();?></h2>
      <h1 class="page-header">
          All Products
      </h1>
      <ol class="breadcrumb">
          <li>
              <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard </a>
          </li>
          <li class="active">
            <i class="fa fa-list-alt" aria-hidden="true"></i> All Products
          </li>
      </ol>
  </div>
  <!--/row-->
</div>
<!--IF no products found message-->
<div class="jumbotron no_product_msg" style="display:none;">
  <h1>No products found!</h1>
  <a class="btn btn-primary" href="index.php?add_new_exist_product"><i class="fa fa-plus"></i> Add new product</a>
</div>
<!--no product div message end -->
<div class="row all_products_table_row">   <!--row start-->
  <div class="col-md-12 table-responsive">
      <table class="all_products_table table">
          <tr>
            <th>S No.</th>
            <th>Title</th>
            <th></th>
            <th>Description</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Color</th>
            <th>Size</th>
            <th>Orginal Price</th>
            <th>Offer Price</th>
            <th>Quantity</th>
            <th><i class="fa fa-wrench"></i></th>
            <th></th>

          </tr>

          <?php display_all_products_in_admin();?>

       </table>
    </div>
</div>    <!---row end-->
<script type="text/javascript">
//Setting variable to check if product count is zero or not (used in edit_delete_product.js)
var products_count = '<?php if(isset($_SESSION['products_count'])){echo $_SESSION['products_count'];}else{echo 'found';} ?>'
</script>
