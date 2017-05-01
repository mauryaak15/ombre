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
 add_product_in_admin();
?>

<?php
//Extracting information from POST superglobal set by new or existing add product form

if(isset($_POST['proceed'])){ //add_existing_product_check form submitted or not
  $new_exist = $_POST['new_or_exist_product'];
  if($new_exist=='exist'){

    if(isset($_POST['product_id']) AND !empty($_POST['product_id'])){ //IF exist selected and product is not selected

      $product_title = $_POST['product_id'];
      $product_id = $_POST['product_id_hidden'];

      //Fetching product category, brand and price

      $query_product_details = query("SELECT * FROM products WHERE product_id = {$product_id}");
      confirm($query_product_details);
      $product_details_row = fetch_array($query_product_details);
      $price = $product_details_row['product_original_price'];
      $offer_price = $product_details_row['product_price'];
      $cat_id = $product_details_row['product_category_id'];
      $brand_id = $product_details_row['brand_id'];
      $desc = $product_details_row['product_short_description'];
      $long_desc = $product_details_row['product_long_description'];


      //Brand name fetch
      $fetch_brand_query = query("SELECT * FROM brands WHERE brand_id = {$brand_id}");
      confirm($fetch_brand_query);
      $brand_row = fetch_array($fetch_brand_query);
      $brand_name = $brand_row['brand_name'];

      //Category name fetch
      $fetch_category_query = query("SELECT * FROM categories WHERE cat_id = {$cat_id}");
      confirm($fetch_category_query);
      $category_row = fetch_array($fetch_category_query);
      $category_name = $category_row['cat_title'];

      if(isset($_POST['color_or_size'])){  //If radio buttons are not selected
        $existing_size_color = $_POST['color_or_size'];

        if($existing_size_color=='size'){

          $product_size = $_POST['exist_product_size'];

        }else if($existing_size_color=='color'){

          $product_color = $_POST['exist_product_color'];

        }else if($existing_size_color=='none'){

        }
      } //Radio selection if end
      else{
        //Redirect back to form with error (Radio not selected)
        set_message("Please select existing color or size or none option!");
        redirect("index.php?add_new_exist_product");
        die();
      }
    } //If product is not selected end
    else{
      //Redirect back to form with error (Product is not selected)
      set_message("Please select the product");
      redirect("index.php?add_new_exist_product");
      die();
    }
  }
} //If form is not submitted
else{
  //Redirect back to form with error  (Form is not submitted or page this page is directly accessed)
  $_SESSION['message'] = "Please Fill the below form first!";
  header("Location: index?add_new_exist_product");
  die();
}

?>

<div class="row">

  <div class="col-md-12">
      <h2 class="text-danger bg-danger text-center"><?php display_message();?></h2>
      <h1 class="page-header">
          Add Product
      </h1>
      <ol class="breadcrumb">
          <li>
              <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard </a>
          </li>
          <li>
            <i class="fa fa-question-circle" aria-hidden="true"></i> <a href="index.php?add_new_exist_product">New or Existing</a>
          </li>
          <li class="active">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product
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
