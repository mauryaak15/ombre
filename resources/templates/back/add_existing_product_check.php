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
      <h2 class="text-danger bg-danger text-center"><?php display_message();?></h2>
      <h1 class="page-header">
          Add Product
      </h1>
      <ol class="breadcrumb">
          <li>
              <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard </a>
          </li>
          <li class="active">
            <i class="fa fa-question-circle" aria-hidden="true"></i> New or Existing
          </li>
      </ol>
  </div>
  <!--/row-->
</div>

<div class="row">
  <form method="post" action="index.php?add_product" name="new_exist_product_form">
    <div class="form-group col-md-4 col-md-offset-4 new_existing_select_div">
      <select name="new_or_exist_product" class="form-control">
        <option value="new">New</option>
        <option value="exist">Existing</option>
      </select>
    </div>
    <div class="form-group col-md-4 col-md-offset-4 search_product_div" style="display:none;">
      <label for="product">Type Product title</label>
      <input type="text" name="product_id" class="form-control" id="product" list="product_list" autocomplete="off">
      <input type="text" name="product_id_hidden" hidden="hidden">
      <datalist id="product_list">
        <!-- dynamic options from ajax call in add_existing_product.js-->
      </datalist>
      <p class="bg-warning text-warning text-center no_result_text" style="display:none; padding: 4px; margin-top:10px;margin-bottom:0px;"></p>
    </div>
    <div class="form-group col-md-4 col-md-offset-4 color_size_div" style="display:none;">
      <div class="checkbox row" style="margin-top:-5px;">
        <label><input type="radio" name="color_or_size" value="size"> Existing Size</label>
      </div>
      <div class="checkbox row">
        <label><input type="radio" name="color_or_size" value="color"> Existing color</label>
      </div>
      <div class="checkbox row" style="margin-bottom:-5px;">
        <label><input type="radio" name="color_or_size" value="none"> None</label>
      </div>
    </div>
    <div class="form-group col-md-4 col-md-offset-4 existing_size_div" style="display:none;">
      <select name="exist_product_size" class="form-control">
      </select>
    </div>
    <div class="form-group col-md-4 col-md-offset-4 existing_color_div" style="display:none;">
      <select name="exist_product_color" class="form-control">
      </select>
    </div>
    <div class="form-group col-md-4 col-md-offset-4">
      <input type="submit" class="form-control btn btn-primary" value="Proceed" name="proceed">
    </div>
  </form>
</div>
