<?php require_once("config.php"); ?>
<?php require_once("cart_functions.php"); ?>

<?php

//When user Click Add to cart button

if(isset($_POST['product_size'])&&isset($_POST['product_color'])&&isset($_POST['add'])){ //Main if starts
    if(!empty($_POST['product_size'])&&!empty($_POST['product_color'])&&!empty($_POST['add'])){
        $product_info = array("product_id"=>escape_string($_POST['add']),
                              "product_size"=>escape_string(strtoupper($_POST['product_size'])),
                              "product_color"=>escape_string(strtoupper($_POST['product_color'])));

        $product_color_info = get_product_color_info($product_info['product_id'],$product_info['product_color']);   //Product color id and total qty
        $product_size_info = get_product_size_qty($product_info['product_id'],$product_color_info['product_color_id'],$product_info['product_size']);
        if($product_color_info==0 || $product_size_info == 0){
          echo "0";
        }else{

          if(!isset(
            $_SESSION['product_'.$product_info['product_id']]['product_color_'.$product_color_info['product_color_id']]['product_size_'.$product_size_info['product_size_id']]
          )){
            $_SESSION['product_'.$product_info['product_id']]['product_color_'.$product_color_info['product_color_id']]['product_size_'.$product_size_info['product_size_id']] = '1';
            echo get_order_count();
          }else{
              if($product_size_info['product_size_qty'] >
                $_SESSION['product_'.$product_info['product_id']]['product_color_'.$product_color_info['product_color_id']]['product_size_'.$product_size_info['product_size_id']]
              ){
                $_SESSION['product_'.$product_info['product_id']]['product_color_'.$product_color_info['product_color_id']]['product_size_'.$product_size_info['product_size_id']] += '1';
                echo get_order_count();
              }else{
                echo "-1";
              }
          }

        }


  }


}

/*When user increases or decreases the quantity of product from cart-items.php
Updating that quantity in Session stored quantity
Don't change echo statement text randomly
if want to change update in cart_update_using_ajax.js file also
*/
if(isset($_POST['product_id'])&&isset($_POST['color_id'])&&isset($_POST['size_id'])&&isset($_POST['qty'])){

  $product_id = escape_string($_POST['product_id']);
  $color_id = escape_string($_POST['color_id']);
  $size_id = escape_string($_POST['size_id']);
  $item_in_cart=false;
  if(!empty($product_id)&&!empty($color_id)&&!empty($size_id)){  //ID's are empty IF
        $qty = escape_string($_POST['qty']);
        if((!empty($qty) || $qty=='0') && $qty > "-1" ){   //Qty received is not empty IF

              if(isset($_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id])){   //product session is set or not

                    //1st Foreach
                    foreach ($_SESSION as $product_key => $product_value) {

                          //1st Foreach IF
                          if($product_key == "product_".$product_id){

                                //2nd Foreach
                                foreach ($product_value as $color_key => $color_value) {

                                      //2nd Foreach IF
                                      if($color_key == "product_color_".$color_id){

                                            //3rd Foreach
                                            foreach ($color_value as $size_key => $ize_value) {

                                                  if($size_key == "product_size_".$size_id){
                                                    $item_in_cart = true;
                                                  }
                                            }   //3rd Foreach end
                                      }   //2nd Foreach IF end
                                } //2nd Foreach end
                          } //1st Foreach IF end
                    } //1st Foreach end
                    if($item_in_cart){
                          $size_qty_query = query("SELECT product_size_qty FROM product_size WHERE product_size_id = {$size_id} AND product_color_id = {$color_id} AND product_id = {$product_id}");
                          confirm($size_qty_query);
                          if(rows($size_qty_query)!=0){   //SQL return zero rows IF
                                while($size_qty_row = fetch_array($size_qty_query)){
                                  $db_size_qty = $size_qty_row['product_size_qty'];
                                }
                                if($db_size_qty == 0){
                                  $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id] = '0';
                                  echo 'Product is out of stock!';
                                }
                                else{    //product stock check
                                      if($qty > $db_size_qty){
                                        echo "Error: quantity not available (only ".$db_size_qty. " available)";
                                      }//else if($qty < 0){
                                        //echo "Error: quantity is negative"};
                                      else if($qty == "0"){
                                        $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id] = '0';
                                        echo "1";
                                      }
                                      //To check if qty is float or not
                                      //We add 0 because qty is string and +0 typecast it into number
                                      else if(is_float($qty+0)){

                                          if(fmod($qty,1) == 0){// if no. is float but have zero after decimal eg. 5.0
                                            echo "1";
                                          }
                                          else{ //eg 5.4
                                            echo 'Please give a valid input!';
                                          }
                                      }
                                      else{
                                        $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id] = $qty;
                                        echo "1";
                                      }
                                }   //product stock check ends
                          }     //SQL return zero rows IF end
                          else{
                            echo "Product not found!";
                          }
                    }
                    else{
                      echo "This item is not in cart!";
                    }

              }//product session is set or not end
              else{
                echo 'Product not found!';
              }

        }    //Qty received is not empty IF
        else{
          echo 'Please give a valid input!';
        }
  }    //ID's are empty IF end
  else{
    echo "ID is missing!";
  }
}

/*When user removes the product from cart-items.php
Unsetting that product Session
Unsetting size session array first then checking if color session array is empty
if color session array is empty we finally unset the whole product session at the bottom IF statement
Don't change echo statement text randomly
if want to change update in cart_update_using_ajax.js file also
*/

if(
  isset($_POST['removePId'])&&isset($_POST['removeColorId'])&&isset($_POST['removeSizeId'])
  &&!empty($_POST['removePId'])&&!empty($_POST['removeColorId'])&&!empty($_POST['removeSizeId'])){

    $product_id = escape_string($_POST['removePId']);
    $color_id = escape_string($_POST['removeColorId']);
    $size_id = escape_string($_POST['removeSizeId']);
    if(isset($_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id])){   //product session is set or not
          unset(
            $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id]
          );

          //1st Foreach
          foreach ($_SESSION as $product_key => $product_value) {

            //1st Foreach IF
            if($product_key == "product_".$product_id){

              //2nd Foreach
              foreach ($product_value as $color_key => $color_value) {

                if($color_key == "product_color_".$color_id){

                  if(empty($color_value)) {
                    unset($_SESSION['product_'.$product_id]['product_color_'.$color_id]);
                  }

                }

              } //2nd Foreach end
            } //1st Foreach IF end
          } //1st Foreach end

          if(empty($_SESSION['product_'.$product_id])){
            unset($_SESSION['product_'.$product_id]);
          }
          echo get_order_count();

          //Updating the database and deleting the product record from cart_items tables
          //if user is logged in
          if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            delete_product_from_cart($user_id,$size_id);
          }
    }
    else{
      echo "Item is not in cart!";
    }
  }

//Get user's selected product in cart (cart-items.php)

function get_cart_products(){

  $total = 0;
  $out_of_stock=-1;
  if(!empty($_SESSION)){  //if $_SESSION is empty or not

          //1st Foreach
          foreach ($_SESSION as $product_key => $product_value) {
            if(substr($product_key, 0, 8) == 'product_'){

              $product_key_length = strlen($product_key);
              $product_id = substr($product_key, 8, $product_key_length);

              //2nd Foreach
              foreach ($product_value as $color_key => $color_value) {
                $color_key_length = strlen($color_key);
                $color_id = substr($color_key, 14, $color_key_length);

                //3rd Foreach
                foreach ($color_value as $size_key => $size_value) {
                  $size_key_length = strlen($size_key);
                  $size_id = substr($size_key, 13, $size_key_length);

                  $product_query = query("SELECT * FROM products WHERE product_id = {$product_id}");
                  confirm($product_query);
                  while($product_row = fetch_array($product_query)){
                    $product_title = $product_row['product_title'];
                    $product_price = $product_row['product_price'];
                    $product_short_description = $product_row['product_short_description'];
                    $product_image = substr($product_row['product_image_1'], 3);
                    $product_brand_id = $product_row['brand_id'];
                  }

                  $brand_query = query("SELECT brand_name FROM brands WHERE brand_id = {$product_brand_id}");
                  confirm($brand_query);
                  while($brand_row = fetch_array($brand_query)){
                    $brand_name = $brand_row['brand_name'];
                  }

                  $color_query = query("SELECT product_color_name FROM product_color WHERE product_color_id = {$color_id}");
                  confirm($color_query);
                  while($color_row = fetch_array($color_query)){
                    $color_name = $color_row['product_color_name'];
                  }

                  $size_query = query("SELECT * FROM product_size WHERE product_size_id = {$size_id}");
                  confirm($size_query);
                  while($size_row = fetch_array($size_query)){
                    $size_name = $size_row['product_size_name'];
                    $db_size_qty = $size_row['product_size_qty'];
                  }
                  $sub_total = $product_price*$size_value;
                  //$total += $sub_total;

                  if($db_size_qty == 0){
                    $out_of_stock = 1;
                    $sub_total = 0;
                    $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id] = '0';

                  }
                  $total += $sub_total;

//DELIMETER STARTS FOR DISPLAYING PRODUCTS

$product_display = <<<DELIMETER
<tr data-stock="{$out_of_stock}">
  <td data-th="Product Name" class="product_column_width">
    <div class="col-sm-12">
      <div class="row">
      <h4><span class="label label-success cart_stock_label center-block xs_cart_stock_label" style="margin-bottom:20px;">In Stock</span></h4>
        <div class="col-sm-2"><img src="{$product_image}" alt="..." class="img-responsive"/></div>
        <div class="col-sm-10 product_title_div">
          <h4 class="nomargin text-left product_title">{$product_title}</h4>
          <p class="hidden-xs text-justify">{$product_short_description}</p>
        </div>
      </div>
  </div>
  </td>

  <td data-th="Brand">{$brand_name}</td>
  <td data-th="Color">{$color_name}</td>
  <td data-th="Size">{$size_name}</td>
  <td data-th="Price" data-price="{$product_price}" class="product_price">Rs. {$product_price}</td>
  <td data-th ="Delivery">Free</td>

  <td data-th="Quantity">
    <input type="number" min="1" max="{$db_size_qty}" class="form-control text-center" value="{$size_value}" data-product-ids="{$product_id}_{$color_id}_{$size_id}">
  </td>

  <td data-th="Subtotal" class="text-center sub_total" data-sub-total="{$sub_total}">Rs.{$sub_total}</td>

  <td class="actions" data-th="">
    <!--<button class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>-->
    <button class="btn btn-danger btn-sm center-block remove_product" data-product-ids="{$product_id}_{$color_id}_{$size_id}"><i class="fa fa-trash-o"></i></button>
    <span class="label label-success cart_stock_label center-block">In Stock</span>
  </td>

</tr>

DELIMETER;
                echo $product_display;
                $out_of_stock = -1;

                }  //3rd Foreach ends

              } //2nd Foreach ends

            } //if statement ends

          } //1st Foreach ends

  }//$_SESSION array empty check

} //Function ends





?>
