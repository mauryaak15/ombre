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
 edit_product_in_admin();
?>

<?php
//Extracting information from GET superglobal set in all products' page edit button

if(isset($_GET['ids']) && !empty($_GET['ids'])){ //If ids are present

  $ids = explode("_",$_GET['ids']); //Product id array ==> [0]product_id, [1]color_id, [2]size_id
  $product_details_query = query("SELECT * FROM products WHERE product_id = {$ids[0]}");
  confirm($product_details_query);
  $product_details_row = fetch_array($product_details_query);
  $product_title = $product_details_row['product_title'];
  $brand_id = $product_details_row['brand_id'];
  $cat_id = $product_details_row['product_category_id'];
  $price = $product_details_row['product_original_price'];
  $offer_price = $product_details_row['product_price'];
  $desc = $product_details_row['product_short_description'];
  $long_desc = $product_details_row['product_long_description'];
  

}else{
  //Redirect back to all products with error (Product id is not found)
  set_message("Product id not found!");
  redirect("index.php?all_products");
  die();
}
?>

<div class="row">

  <div class="col-md-12">
      <h2 class="text-danger bg-danger text-center"><?php display_message();?></h2>
      <h1 class="page-header">
          Edit Product
      </h1>
      <ol class="breadcrumb">
          <li>
              <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard </a>
          </li>
          <li class="active">
            <i class="fa fa-pencil" aria-hidden="true"></i> Edit Product
          </li>
      </ol>
  </div>

  <!--/row-->
</div>
<div class="row">
  <div class="col-md-12">
    <form method="post" action="" enctype="multipart/form-data" name="add_product_form" >
      <div class="form-group col-md-8">
        <label for="product_title">Product Title</label>
        <input type="text" class="form-control" id="product_title" name="product_title" value="<?php if(isset($product_title)){echo $product_title;}?>">
        <input type="text" hidden="hidden" name="product_id" value="<?php if(isset($product_id)){echo $product_id;}else{echo "new";}?>" >
        <input type="text" hidden="hidden" name="color_or_size_or_none" value="<?php if(isset($existing_size_color)){echo $existing_size_color;}?>" >
      </div>
      <div class="form-group col-md-4">
        <label for="product_category">Product Category</label>
        <select class="form-control" id="product_category" name="category">
          <?php get_categories_in_add_prod(); ?>
        </select>
        <input type="text" name="category" hidden="hidden" disabled="disabled">
      </div>
      <div class="form-group col-md-8">
        <label for="product_long_desc">Brief Product Description</label>
        <textarea class="form-control" id="product_long_desc" rows="10" name="product_long_desc" ><?php if(isset($long_desc)){echo $long_desc;}?></textarea>
      </div>

      <div class="form-group col-md-4">
        <label for="product_qty">Product Quantity</label>
        <input type="number" min="0" class="form-control" id="product_qty" name="product_qty">
      </div>
      <div class="form-group col-md-4">
        <label for="product_brand">Product Brand</label>
        <select class="form-control" id="product_brand" name="brand">
          <?php get_brands_in_add_prod(); ?>
        </select>
        <input type="text" name="brand" hidden="hidden" disabled="disabled">
      </div>
      <div class="form-group col-md-4">
        <label for="product_image">Choose Image (Max 5)</label>
        <input type="file" id="product_image" name="product_image[]" multiple="multiple" accept="image/*" onchange="previewImage(event);">
      </div>
      <div class="col-md-4 img_preview_div">
      </div>
      <div style="clear:both;"></div>
      <div class="form-group col-md-8">
        <label for="product_short_desc">Product Short Description</label>
        <textarea class="form-control" id="product_short_desc" rows="5" name="product_short_desc"><?php if(isset($desc)){echo $desc;}?></textarea>
      </div>
      <div class="form-group col-md-4 hidden-xs hidden-sm">
        <button class="btn btn-warning btn-lg" type="button"><i class="fa fa-print"></i> Draft</button>
        <button class="btn btn-primary btn-lg" type="submit" name="submit"><i class="fa fa-envelope"></i> Publish</button>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-6 form-group">
              <label for="product_original">Product Original Price</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                <input type="number" step="0.01" min="0" class="form-control" id="product_original" name="product_original_price" value="<?php if(isset($price)){echo $price;}?>" >
              </div>
          </div>
          <div class="col-md-6 form-group">
              <label for="product_current">Product Offer Price</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                <input type="number" step="0.01" min="0" class="form-control" id="product_current" name="product_offer_price" value="<?php if(isset($offer_price)){echo $offer_price;}?>" >
              </div>
          </div>
          <div class="form-group col-md-6">
            <label for="product_size">Product Size</label>
            <select class="form-control" id="product_size" name="size">
              <option value="XS">XS</option>
              <option value="S">S</option>
              <option value="M">M</option>
              <option value="L">L</option>
              <option value="XL">XL</option>
              <option value="XXL">XXL</option>
            </select>
            <input type="text" name="size" hidden="hidden" disabled="disabled">
          </div>
          <div class="col-md-6 form-group">
              <label for="product_color">Product Color</label>
              <input type="text" class="form-control" id="product_color" name="color" value="<?php if(isset($product_color)){echo $product_color;}?>" >
          </div>
        </div>
      </div>
      <div class="form-group col-md-8 visible-xs visible-sm">
        <button class="btn btn-warning btn-lg" type="button"><i class="fa fa-print"></i> Draft</button>
        <button class="btn btn-primary btn-lg" type="submit" name="submit"><i class="fa fa-envelope"></i> Publish</button>
      </div>

    </form>
  </div>
</div>
<script type="text/javascript">

//Var defclaration for add_product.js
var new_exist = '<?php if(isset($new_exist)){echo $new_exist;}else{echo '';}?>';
var existing_size_color = '<?php if(isset($existing_size_color)){echo $existing_size_color;}else{echo '';}?>';
if(existing_size_color=='size'){
  var size = '<?php if(isset($product_size)){echo $product_size;}else{echo '';}?>';
}
var category_name = '<?php if(isset($category_name)){echo $category_name;}else{echo '';}?>';
var cat_id = '<?php if(isset($cat_id)){echo $cat_id;}else{echo '';}?>';
var brand_name = '<?php if(isset($brand_name)){echo $brand_name;}else{echo '';}?>';
var brand_id = '<?php if(isset($brand_id)){echo $brand_id;}else{echo '';}?>';
</script>
