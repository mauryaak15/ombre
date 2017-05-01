<?php
//helper functions

function set_message($msg){
  if(!empty($msg)){
    $_SESSION['message'] = $msg;
  }else{
    $msg="";
  }
}

function display_message(){
  if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  }
}

function redirect($location){
  header("LOCATION: $location");
}

function query($sql){
  global $connection;
  return mysqli_query($connection, $sql);
}

function rows($sql){
  return mysqli_num_rows($sql);
}

function confirm($result){
  global $connection;
  if(!$result){
    die("QUERY FAILED: ".mysqli_error($connection));
  }
}

function escape_string($string){
  global $connection;
  return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
  return mysqli_fetch_array($result);
}

/********************************FRONT END FUNCTIONS ******************************************/

//get only 10 products in slider in index.php

function get_products_in_slider(){
  $query = query("SELECT * FROM products");
  confirm($query);
  $i=1;
  while($row = fetch_array($query)){
    if($i>10){
      break;
    }
    $product_image = substr($row['product_image_1'],3);
    $product = <<<DELIMETER
<div class="product-main-cont">
  <div class="product-img">
    <a href="product-info.php?id={$row['product_id']}"><img src="{$product_image}" class="img-responsive"></a>
  </div>
  <div class="prod-title-price">
    <p><a href="product-info.php?id={$row['product_id']}">{$row['product_title']}</a></p>
    <p class="price">Rs.{$row['product_price']} <span>Rs.{$row['product_original_price']}</span></p>
  </div>
</div>
DELIMETER;
    echo $product;
    $i++;
  }
}

//get all products in shop.php

function get_all_products_in_shop(){
  $query = query("SELECT * FROM products");
  confirm($query);
  while($row = fetch_array($query)){
    $product_image = substr($row['product_image_1'],3);
    $product = <<<DELIMETER
<div class="col-md-3 col-xs-6 col-sm-4 all-padding-zero marg-bot-up">
  <div class="product-main-cont">
    <div class="product-img">
      <a href="product-info.php?id={$row['product_id']}"><img src="{$product_image}" class="img-responsive"></a>
    </div>
    <div class="prod-title-price">
      <p><a href="product-info.php?id={$row['product_id']}">{$row['product_title']}</a></p>
      <p class="price">Rs.{$row['product_price']} <span>Rs.{$row['product_original_price']}</span></p>
    </div>
  </div>
</div>
DELIMETER;
    echo $product;
  }
}

//get only 4 categories in index.php

function get_4_categories(){
  $query = query("SELECT * FROM categories");
  confirm($query);
  $i=1;
  while($row = fetch_array($query)){
    if($i>4){
      break;
    }
    $categories = <<<DELIMETER
<a href="cat-products.php?id={$row['cat_id']}"><div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
    <div class="product-icon-container">
        <div class="product-icon">
            <img alt="kurti" src="{$row['cat_image']}"class="avatar">
        </div>
        <hr class="product-hr">
        <div class="product-heading text-center">
            <h4>{$row['cat_title']}</h4>
        </div>
    </div>
</div></a>
DELIMETER;
    echo $categories;
    $i++;
  }
}

//get all categories in categories.php

function get_all_categories(){
  $query = query("SELECT * FROM categories");
  confirm($query);
  while($row = fetch_array($query)){
    $categories = <<<DELIMETER
<a href="cat-products.php?id={$row['cat_id']}"><div class="col-md-3 col-xs-6 all-padding-zero marg-bot-up">
    <div class="product-icon-container">
        <div class="product-icon">
            <img alt="kurti" src="{$row['cat_image']}"class="avatar">
        </div>
        <hr class="product-hr">
        <div class="product-heading text-center">
            <h4>{$row['cat_title']}</h4>
        </div>
    </div>
</div></a>
DELIMETER;
    echo $categories;
  }
}

//get product details on cat-products.php

function get_cat_products(){
  if(isset($_GET['id'])&&!empty($_GET['id'])){
    $cat_id = escape_string($_GET['id']);
    $query = query("SELECT * FROM products WHERE product_category_id={$cat_id}");
    confirm($query);
    if(!rows($query)){
      echo '<h1 class="bg-danger text-danger text-center">No products found in this category</h1>';
    }else{
      while($row=fetch_array($query)){
        $product_image = substr($row['product_image_1'],3);
        $cat_products = <<< DELIMETER
<div class="col-md-3 col-xs-6 col-sm-4 all-padding-zero marg-bot-up">
  <div class="product-main-cont">
    <div class="product-img">
      <a href="product-info.php?id={$row['product_id']}"><img src="{$product_image}" class="img-responsive"></a>
    </div>
    <div class="prod-title-price">
      <p><a href="product-info.php?id={$row['product_id']}">{$row['product_title']}</a></p>
      <p class="price">Rs. {$row['product_price']} <span>Rs. {$row['product_original_price']}</span></p>
    </div>
  </div>
</div>
DELIMETER;
        echo $cat_products;
      }
    }

  }else{
    die('<h1 class="bg-danger text-danger text-center">Id is missing</h1>');
  }
}

//Contact form submission function

function send_message(){
  if(isset($_POST['submit'])){
    $to = 'tuesdaystorage2@gmail.com';
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $name = $_POST['name'];
    $header = "FROM: {$name} {$email}";
    $result = mail($to, $subject, $message, $header);
    if(!$result){
      set_message("Error in sending mail! Please try again later");
      redirect("contact.php");
    }else{
      set_message("Your message has been sent");
      redirect("contact.php");
    }
  }
}

//Fetching Username from user id of logged in user

function get_user_name($user_id){
  $query = query("SELECT username FROM users WHERE user_id={$user_id}");
  confirm($query);
  while($row = fetch_array($query)){
    $username = $row['username'];
  }
  return $username;
}

//Counter of products in cart (number on cart icon of menu)

function get_order_count(){
  $i=0;
  foreach ($_SESSION as $product_key => $product_value) {
    if(substr($product_key, 0, 8) == "product_"){
        foreach ($product_value as $color_key => $color_value) {
          foreach ($color_value as $size_key => $size_value) {
            ++$i;
          }
        }
      }
  }
  return $i;
}


/*****************************************************************************************************************
 * Function to check if any product is locked for more than 10 minutes
 * If yes then increase the quantity before displaying the product in product-info.php
 ****************************************************************************************************************/

 function check_locked_products($product_id){
   date_default_timezone_set('Asia/Kolkata');   //To ensure it display correct time
   $locked_product_check_query =  query("SELECT * FROM product_current_available_stock WHERE product_id = {$product_id}");
   confirm($locked_product_check_query);
   while($row = fetch_array($locked_product_check_query)){
     $timestamp = $row['timestamp'];
     $locked_qty = $row['product_quantity'];
     $color_id = $row['product_color_id'];
     $size_id = $row['product_size_id'];
     $locked_id = $row['id'];
     $last_time = strtotime($timestamp);
     $current_time = strtotime(date('Y-m-d H:i:s'));
     $elapsed_time = round(abs($current_time - $last_time)/60,0); //In minutes(/60)
     if($elapsed_time > '10'){ //If elapsed time is more then 10 min then increment the product quantity again

       $update_product_qty_query = query("UPDATE products SET product_qty = product_qty + {$locked_qty} WHERE product_id = {$product_id}");
       confirm($update_product_qty_query);

       $update_product_color_qty_query = query("UPDATE product_color SET product_color_qty = product_color_qty + {$locked_qty} WHERE product_id = {$product_id} AND product_color_id = {$color_id}");
       confirm($update_product_color_qty_query);

       $update_product_size_qty_query = query("UPDATE product_size SET product_size_qty = product_size_qty + {$locked_qty} WHERE product_id = {$product_id} AND product_color_id = {$color_id} AND product_size_id = {$size_id}");
       confirm($update_product_size_qty_query);

       //Delete the entry from product_current_available_stock Table
       $delete_locked_product_entry_query = query("DELETE FROM product_current_available_stock WHERE id = {$locked_id}");
       confirm($delete_locked_product_entry_query);
     }
   }
 }


/*********************************CART ITEMS CRUD OPERATIONS FOR DATABASE******************************************/

/*
*Function called during login activity
*Check if user already have items in cart before login
*If present then save those items in cart_items table
*Also check if item already in user's cart then don't create redundant entry only
*update the quantity value
*/

function save_session_cart_after_login($user_id){
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

                    //IF already in database or not
                    $product_exist_query = query("SELECT cart_items_id FROM cart_items WHERE product_size_id = {$size_id} AND user_id = {$user_id}");
                    confirm($product_exist_query);
                    if(rows($product_exist_query)!=0){
                        while($row = fetch_array($product_exist_query)){
                          $cart_items_id = $row['cart_items_id'];
                        }
                        //If present then update the quantity of that product
                        $product_quantity_update_query = query("UPDATE cart_items SET quantity={$size_value} WHERE cart_items_id = {$cart_items_id}");
                        confirm($product_quantity_update_query);
                      }
                      //IF item is not in database before make new entry
                      else{
                        $save_cart_product_query = query("INSERT INTO cart_items (user_id,product_id,product_color_id,product_size_id,quantity) VALUES({$user_id},{$product_id},{$color_id},{$size_id},{$size_value})");
                        confirm($save_cart_product_query);
                      }
                }  //3rd Foreach ends

              } //2nd Foreach ends

            } //if statement ends

          } //1st Foreach ends

      }//$_SESSION array empty check
}



/*
*If user removes item from cart then
*removing the record from the database
*called in cart.php for
*/

function delete_product_from_cart($user_id,$size_id){
  $cart_product_removal_query = query("DELETE FROM cart_items WHERE user_id={$user_id} AND product_size_id={$size_id}");
  confirm($cart_product_removal_query);
}



/*
*If user logged in then load the already saved cart items
*if item is added before login and after login it is already
*in cart then update the quantity of that prodouct in cart
*after fetching create the sessions of all products
*/

function fetch_cart_items($user_id){
      if(!empty($_SESSION)){  //if $_SESSION is empty or not
            //1st Foreach
            $i=0;
            foreach ($_SESSION as $product_key => $product_value) {
              if(substr($product_key, 0, 8) == 'product_'){
                $product_key_length = strlen($product_key);
                $size_id_array = [];
                $size_id_string;
                $product_id = substr($product_key, 8, $product_key_length);

                //2nd Foreach
                foreach ($product_value as $color_key => $color_value) {
                  $color_key_length = strlen($color_key);
                  $color_id = substr($color_key, 14, $color_key_length);


                  //3rd Foreach
                  foreach ($color_value as $size_key => $size_value) {
                      $size_key_length = strlen($size_key);
                      $size_id = substr($size_key, 13, $size_key_length);
                      $size_id_array[$i] = $size_id; //saving all size ids in array
                      $i++;
                  }  //3rd Foreach ends

                } //2nd Foreach ends

              } //if statement ends

            } //1st Foreach ends
            if(!empty($size_id_array)){
                  $size_id_string = implode(',',$size_id_array);

                  /*Fetching all the items from database which are not in size id string
                  *(Items which are not in session but in user's cart before)
                  */
                    $fetch_cart_product_query = query("SELECT * FROM cart_items WHERE user_id = {$user_id} AND product_size_id NOT IN({$size_id_string})");
                    confirm($fetch_cart_product_query);
                    if(rows($fetch_cart_product_query) > 0){
                        while($product_row = fetch_array($fetch_cart_product_query)){
                          $product_id = $product_row['product_id'];
                          $color_id = $product_row['product_color_id'];
                          $size_id = $product_row['product_size_id'];
                          $quantity = $product_row['quantity'];
                          $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id] = $quantity;
                        }
                    }
            }
            else{
                $fetch_cart_product_query = query("SELECT * FROM cart_items WHERE user_id = {$user_id}");
                confirm($fetch_cart_product_query);
                if(rows($fetch_cart_product_query) > 0){
                    while($product_row = fetch_array($fetch_cart_product_query)){
                      $product_id = $product_row['product_id'];
                      $color_id = $product_row['product_color_id'];
                      $size_id = $product_row['product_size_id'];
                      $quantity = $product_row['quantity'];
                      $_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id] = $quantity;
                    }
                }
            }

        }//$_SESSION array empty check
}

/****************************************Register Helper Functions***********************************************/

/*Function to check mobile is verified or not during registration
*(register_script.php)
*/

function checkStatus($mobileNumber){
    $baseUrl = "http://sendotp.msg91.com/api";
  		$refreshToken = "";
  	   if(isset($_SESSION['refreshToken'])){
  		    $refreshToken = $_SESSION['refreshToken'];
  		   }
         $ch = $ch = curl_init($baseUrl."/checkNumberStatus?refreshToken=".$refreshToken."&countryCode=91&mobileNumber=".$mobileNumber);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_AUTOREFERER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json',
             'application-key : 9jc_UPOgZQYw35NnoSWEGpvu3-yi7S9TfnljDrlW5SseDNK2MojbvG0avMbyvkIrkPGYYKPNlAuh3cIviZvWbjw0EXjNEAn14PQKBIcIqzAUMCFrQlPH_QQ-0PpRDzy4R45na6iqWBnHpp4YAahbog=='
         ));
         $result = curl_exec($ch);
         curl_close($ch);
  	   $response = json_decode($result, true);
  	   if ($response["status"] == "error") {
        //customize this as per your framework
        return $response["response"]["code"];
      } else {
  		return "NUMBER IS VERIFIED";
      }
}

/*************************************Checkout Helper functions*******************************************/

//Display products in checkout review

function display_products_in_checkout(){
  $total = 0;
  $subtotal = 0;
  $out_of_stock=-1;
  $items = 0;
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
                    $product_image = substr($product_row['product_image_1'],3);
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

                  }
                  $total += $sub_total;

//DELIMETER STARTS FOR DISPLAYING PRODUCTS

$product_display = <<<DELIMETER

<div class="col-md-9">
    <table class="table table-striped table-responsive text-right">
        <tr>
            <td colspan="3" class="text-center">
                <h4>{$product_title}
                  <br>
                  <small>
                    {$product_short_description}
                  </small>
                </h4>
              </td>
        </tr>
        <tr>
            <th>Price</th>
            <td>Rs. {$product_price}</td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>{$size_value}</td>
        </tr>
        <tr>
            <th>Seller</th>
            <td>{$brand_name}</td>
        </tr>
        <tr>
            <th>Delivery</th>
            <td>Free Delivery in 4 Days</td>
        </tr>
    </table>
</div>
<div class="col-md-3 sub_total_div">
    <div class="text-center">
        <h3>Sub Total</h3>
        <h3><span class="text-success">Rs. {$sub_total}</span></h3>
    </div>
</div>

DELIMETER;

          //To display only stock products

              if($out_of_stock != 1 && $size_value > 0){
                echo $product_display;
                ++$items;
              }else{
                $out_of_stock = -1;
              }

                }  //3rd Foreach ends

              } //2nd Foreach ends

            } //if statement ends

          } //1st Foreach ends

  }//$_SESSION array empty check

  $_SESSION['checkout_total'] = $total;
  $_SESSION['checkout_total_items'] = $items;

} //Function ends


//Function to display billing information in checkout.php

function get_user_address(){
  //check if user session is set or not
  if(isset($_SESSION['user_id']) && $_SESSION != ""){
    $user_id = $_SESSION['user_id'];
    $user_info_query = query("SELECT * FROM users WHERE user_id = {$user_id}");
    confirm($user_info_query);
    while($user_info_row = fetch_array($user_info_query)){
      $fname = $user_info_row['first_name'];
      $lname = $user_info_row['last_name'];
    }
    $address_query = query("SELECT * FROM address WHERE user_id = {$user_id}");
    confirm($address_query);
    if(rows($address_query)!= '0'){    //If address found start
      //address while start
      while($address_row = fetch_array($address_query)){
        $address = $address_row['address'];
        $state = $address_row['state'];
        $city = $address_row['city'];
        $zip  = $address_row['zipcode'];
        $phone = $address_row['phone'];
        $address_id = $address_row['address_id'];

$address_display = <<<DELIMETER
  <label class="address_label">
    <input type="radio" value="{$address_id}" name="address_choice" class="address_checkox" hidden="hidden">
    <table class="table table-striped table-responsive address_table">
        <tr>
            <td class="text-center">
                <h4 class="address_holder_name">{$fname} {$lname}</h4>
            </td>
            <td class="text-right edit-delete-btns">
                <button type="button" class="btn btn-warning btn-xs edit-btn" data-address-id="address_id_{$address_id}"><span class="fa fa-pencil"></span></button>
                <button type="button" class="btn btn-danger btn-xs delete-btn" data-address-id="address_id_{$address_id}"><span class="fa fa-trash-o"></span></button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
              <div class="address_div">
                {$address}<br>
                {$city}<br>
                {$state}<br>
                {$zip}
              </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
              <div class="phone_div">
                {$phone}
              </div>
            </td>
        </tr>
    </table>
  </label>
DELIMETER;
            echo $address_display;
      }//address while end

    }//If address found end

  }  //If user session is set or not

}   //function ends


/*My orders page (To display user's orders if any)*/

function display_orders(){
  if(isset($_SESSION['user_id'])){    //user is logged in check
    $user_id = $_SESSION['user_id'];
    $fetch_order_query = query("SELECT * FROM orders WHERE user_id = {$user_id}");
    confirm($fetch_order_query);
    $order_count = rows($fetch_order_query);
    if($order_count > 0){   //User has one or more order

      while($order_row = fetch_array($fetch_order_query)){ //While start
        $order_id = $order_row['order_id'];
        $order_amount = $order_row['order_amount'];
        $order_quantity = $order_row['order_quantity'];
        $order_status = $order_row['order_status'];
        $order_date_time = $order_row['order_date_time'];
        $order_date_time = date("l, F d,Y",strtotime($order_date_time));
        $address_id = $order_row['address_id'];
        $payment_method = $order_row['payment_method'];
        $address_query = query("SELECT * FROM address WHERE address_id = {$address_id}");
        confirm($address_query);
        $address_row = fetch_array($address_query);
        $address = $address_row['address'];
        $state = $address_row['state'];
        $city = $address_row['city'];
        $zipcode = $address_row['zipcode'];
        $phone = $address_row['phone'];
        $order_table_tr = <<< DELIMETER
        <tr>
          <td data-th="Order id: ">{$order_id}</td>
          <td data-th="Order quantity: " class="td-center">{$order_quantity}</td>
          <td data-th="Order amount: ">Rs. {$order_amount}</td>
          <td data-th="Order status: "><span class="label label-primary">Approved</span></td>
          <td data-th="Mode of payment: " class="td-center">{$payment_method}</td>
          <td data-th="Placed on: ">{$order_date_time}</td>
          <td data-th="Delivery date: ">Thursday, Feburary 26,2017</td>
          <td data-th="Shipping address: ">{$address},
            {$city},
            {$state} - {$zipcode}
          </td>
          <td data-th=""><a href="order_details.php?OrderID={$order_id}" class="btn btn-sm btn-info">View details</a></td>
        </tr>
DELIMETER;
        echo $order_table_tr;
      } //While end


    }   //User logged in check end
  }   //User has one or more order

}

//To find the order count of user (For removing the order via js if order count is less than 1 or zero)
function return_order_count(){
  if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $fetch_order_query = query("SELECT * FROM orders WHERE user_id = {$user_id}");
    confirm($fetch_order_query);
    $order_count = rows($fetch_order_query);
    return $order_count;
  }
}


/*Order Details page (To display user's order details if any)*/

function display_order_details(){
  if(isset($_SESSION['user_id']) AND isset($_GET['OrderID'])){    //user is logged in check
    $user_id = $_SESSION['user_id'];
    $order_id = $_GET['OrderID'];
    $fetch_report_query = query("SELECT * FROM reports WHERE order_id = '{$order_id}'");
    confirm($fetch_report_query);

    while($report_row = fetch_array($fetch_report_query)){ //While start
      $report_id = $report_row['report_id'];
      $item_amount = $report_row['product_current_price'];
      $item_quantity = $report_row['product_quantity'];
      $item_status = $report_row['status'];
      $delivery_date = $report_row['delivery_date'];
      $delivery_date = date("l, F d,Y",strtotime($delivery_date));
      $product_id = $report_row['product_id'];
      $product_color_id = $report_row['product_color_id'];
      $product_size_id = $report_row['product_size_id'];
      $product_details_query = query("SELECT * FROM products WHERE product_id = {$product_id}");
      confirm($product_details_query);
      $product_details_row = fetch_array($product_details_query);
      $product_title = $product_details_row['product_title'];
      $product_price = $product_details_row['product_price'];
      $product_image = substr($product_details_row['product_image_1'],3);
      $product_short_description = $product_details_row['product_short_description'];
      $product_color_query = query("SELECT `product_color_name` FROM product_color WHERE product_color_id = {$product_color_id}");
      confirm($product_color_query);
      $product_color_row = fetch_array($product_color_query);
      $product_color = $product_color_row['product_color_name'];
      $product_size_query = query("SELECT `product_size_name` FROM product_size WHERE product_size_id = {$product_size_id}");
      confirm($product_size_query);
      $product_size_row = fetch_array($product_size_query);
      $product_size = $product_size_row['product_size_name'];
      $total_amount = $product_price*$item_quantity;
      $item_table_tr = <<< DELIMETER
      <tr>
        <td data-th="S no.: " class="td-center">1</td>
        <td data-th="Item name: " class="td-center">{$product_title}</td>
        <td data-th=""><img class="img-responsive" src="{$product_image}" alt="product image"></td>
        <td data-th="Short Description: ">{$product_short_description}</td>
        <td data-th="Item size: " class="td-center">{$product_size}</td>
        <td data-th="Item color: " class="td-center">{$product_color}</td>
        <td data-th="Item quantity: " class="td-center">{$item_quantity}</td>
        <td data-th="Item price: " class="td-center">Rs. {$product_price}</td>
        <td data-th="Order status: " class="td-center"><span class="label label-primary">Approved</span></td>
        <td data-th="Total amount: " class="td-center">Rs. {$total_amount}</td>
        <td data-th="Delivery date: " class="td-center">Thursday, Feburary 26,2017</td>
      </tr>
DELIMETER;
      echo $item_table_tr;
    } //While end

    }   //User logged in check end

}


/****************************************************************************************************************************
 *                                     ADMIN PANEL FUNCTIONS                                                                *
 ****************************************************************************************************************************/

//Function to display category in select options in add new product page of admin

function get_categories_in_add_prod(){
  $cat_query = query("SELECT * FROM categories");
  confirm($cat_query);
  while($cat_rows = fetch_array($cat_query)){
    echo '<option value="'.$cat_rows['cat_id'].'">'.$cat_rows['cat_title'].'</option>';
  }
}

//Function to display brands in select options in add new product page of admin

function get_brands_in_add_prod(){
  $brand_query = query("SELECT * FROM brands");
  confirm($brand_query);
  while($brand_rows = fetch_array($brand_query)){
    echo '<option value="'.$brand_rows['brand_id'].'">'.$brand_rows['brand_name'].'</option>';
  }
}

//Function to add new product in admin

function add_product_in_admin(){
  if(isset($_POST['submit'])){
    $title = escape_string($_POST['product_title']);
    $cat_id = escape_string($_POST['category']);
    $long_desc = escape_string($_POST['product_long_desc']);
    $qty = escape_string($_POST['product_qty']);
    $brand_id = escape_string($_POST['brand']);
    $short_desc = escape_string($_POST['product_short_desc']);
    $original_price = escape_string($_POST['product_original_price']);
    $offer_price = escape_string($_POST['product_offer_price']);
    $color = strtoupper(escape_string($_POST['color']));
    $size = strtoupper(escape_string($_POST['size']));
    $product_exist_id = escape_string($_POST['product_id']);

    if(!empty($title)&&
       !empty($cat_id)&&
       !empty($long_desc)&&
       !empty($qty)&&
       !empty($brand_id)&&
       !empty($short_desc)&&
       !empty($original_price)&&
       !empty($offer_price)&&
       !empty($color)&&
       !empty($size)&&
       !empty($product_exist_id)&&
       !empty($_FILES['product_image']['name'])){

         //If quantity is not a whole number

         if(strval($qty) != strval(intval($qty))){
           set_message("Quantity must be an integer.");
           redirect("../admin/index.php?add_new_exist_product");
           die();
         }

         //If price is not either float or integer
         if((!is_numeric($original_price))&& (!is_numeric($offer_price))){
           set_message("Price must be integer or float value.");
           redirect("../admin/index.php?add_new_exist_product");
           die();
         }



         //If images are more than 5
         if(count($_FILES['product_image']['name'])>5){
           set_message("Images must be equal or less than 5");
           redirect("../admin/index.php?add_new_exist_product");
           die();
         }

         //If Product is new
         if($product_exist_id == 'new'){
           //Inserting Record of prooduct and fetching the product id to insert images in the same record
           $add_prod_query = query("INSERT INTO products (`product_title`,`product_category_id`,`brand_id`,`product_original_price`,`product_price`,`product_short_description`,`product_long_description`,`product_qty`) VALUES('{$title}',{$cat_id},{$brand_id},{$original_price},{$offer_price},'{$short_desc}','{$long_desc}',{$qty})");
           confirm($add_prod_query);
           global $connection;
           $product_id = mysqli_insert_id($connection);

           //Inserting Size Record and fetching the color id

           $add_color_query = query("INSERT INTO product_color (`product_id`, `product_color_name`,`product_color_qty`) VALUES({$product_id},'{$color}',{$qty})");
           confirm($add_color_query);
           $color_id = mysqli_insert_id($connection);

           //Inserting Color Record and fetching the size id

           $add_size_query = query("INSERT INTO product_size (`product_id`, `product_color_id`, `product_size_name`,`product_size_qty`) VALUES({$product_id}, {$color_id}, '{$size}',{$qty})");
           confirm($add_color_query);
           $color_id = mysqli_insert_id($connection);

         }else{ //If product record is existing
           $color_or_size_or_none = $_POST['color_or_size_or_none'];
           $product_id = $product_exist_id;
           //Update existing product
           $update_product = query("UPDATE products SET product_qty = product_qty + {$qty} WHERE product_id = {$product_id}");
           confirm($update_product);
           //Update existing color or size record
           if($color_or_size_or_none == 'color'){
             //Update existing color record and fetching color id
             $update_product_color = query("UPDATE product_color SET product_color_qty = product_color_qty + {$qty} WHERE product_id = {$product_id} AND product_color_name = '{$color}'");
             confirm($update_product_color);
             $color_id_query = query("SELECT product_color_id FROM product_color WHERE product_id = {$product_id} AND product_color_name = '{$color}'");
             confirm($color_id_query);
             $color_id_row = fetch_array($color_id_query);
             $color_id = $color_id_row['product_color_id'];
             //Check wether the size is exist or not
             $size_exist_query = query("SELECT * FROM product_size WHERE product_color_id = {$color_id} AND product_id = {$product_id} AND product_size_name = '{$size}'");
             confirm($size_exist_query);
             if(rows($size_exist_query)!=0){
               //Size exist
               //Updating Size Record for existing product and existing product color (size also exist)
               $size_id_row = fetch_array($size_exist_query);
               $size_id = $size_id_row['product_size_id'];
               $update_size_query = query("UPDATE product_size SET product_size_qty = product_size_qty + {$qty} WHERE product_size_id = {$size_id}");
               confirm($update_size_query);
             }else{
               //Size does not exist
               //Inserting Size Record for existing product and existing product color
               $add_size_query = query("INSERT INTO product_size (`product_id`, `product_color_id`, `product_size_name`,`product_size_qty`) VALUES({$product_id},{$color_id},'{$size}',{$qty})");
               confirm($add_size_query);
             }

           }else if($color_or_size_or_none == 'size'){
             //Check if color is also existing or not
             $check_color_exist = query("SELECT * FROM product_color WHERE product_id = {$product_id} AND product_color_name = '{$color}'");
             confirm($check_color_exist);
             if(rows($check_color_exist)!=0){
               //If color exist
               //Updating product color record for existing color and existing size
               $color_id_row = fetch_array($check_color_exist);
               $color_id = $color_id_row['product_color_id'];
               $update_color_query = query("UPDATE product_color SET product_color_qty = product_color_qty + {$qty} WHERE product_color_id = {$color_id}");
               confirm($update_color_query);
               //Updating product size record for existing color and existing size
               $update_size_query = query("UPDATE product_size SET product_size_qty = product_size_qty + {$qty} WHERE product_id = {$product_id} AND product_color_id = {$color_id} AND product_size_name = '{$size}'");
               confirm($update_size_query);
             }else{
               //If color does not exist (If color is not same then size automatically different)
               //Inserting Color Record for existing product
               $add_color_query = query("INSERT INTO product_color (`product_id`, `product_color_name`,`product_color_qty`) VALUES({$product_id},'{$color}',{$qty})");
               confirm($add_color_query);
               global $connection;
               $color_id = mysqli_insert_id($connection);
               //Inserting Size Record for existing product
               $add_size_query = query("INSERT INTO product_size (`product_id`,`product_color_id`,`product_size_name`,`product_size_qty`) VALUES({$product_id},{$color_id},'{$size}',{$qty})");
               confirm($add_size_query);
             }
           }else if($color_or_size_or_none == 'none'){  //If none is selected from radio buttons in product form
             //Inserting Color Record for existing product
             $add_color_query = query("INSERT INTO product_color (`product_id`, `product_color_name`,`product_color_qty`) VALUES({$product_id},'{$color}',{$qty})");
             confirm($add_color_query);
             global $connection;
             $color_id = mysqli_insert_id($connection);
             //Inserting Size Record for existing product
             $add_size_query = query("INSERT INTO product_size (`product_id`,`product_color_id`,`product_size_name`,`product_size_qty`) VALUES({$product_id},{$color_id},'{$size}',{$qty})");
             confirm($add_size_query);
           }
         }  //Product record existing else end

         for($i=0;$i<count($_FILES['product_image']['name']);++$i){

           $count = count($_FILES['product_image']['name']);
           $image_name = escape_string($_FILES['product_image']['name'][$i]);
           $ext = pathinfo($image_name, PATHINFO_EXTENSION);
           $image_type = $_FILES['product_image']['type'][$i];
           $image_size = $_FILES['product_image']['size'][$i];
           $image_tmp_name = $_FILES['product_image']['tmp_name'][$i];
           $directory = "../resources/uploads/product_image/";
           $image_new_name = rand(9999,100000).md5($image_name).rand(9999,100000).'.'.$ext;
           $target_file = $directory . basename($image_new_name);

           //Uploading image code
           if ($_FILES['product_image']['error'][$i]) {
               set_message("Images upload failed with error code " . $_FILES['product_image']['error']);
               redirect("../admin/index.php?add_new_exist_product");
               die();
             } //Upload error if end*/

             else{
               if(file_exists($target_file)){ //If file with same name exist
                 set_message("Image with the same name already exist");
                 redirect("../admin/index.php?add_new_exist_product");
                 die();
               } //image already exist if end
               else{
                 $check = getimagesize($image_tmp_name);
                 if($check !== false) {
                   if (($check[2] !== IMAGETYPE_GIF) && ($check[2] !== IMAGETYPE_JPEG) && ($check[2] !== IMAGETYPE_PNG)) {
                       set_message("Image must be a gif/jpeg/png");
                       redirect("../admin/index.php?add_new_exist_product");
                       die();
                     } //restricting the extensions
                     else{
                       if(move_uploaded_file($image_tmp_name, $target_file)){ //If file moved successfully
                         $col_name = 'product_image_'.($i+1);
                         $img_loc_query = query("UPDATE products SET `{$col_name}`='{$target_file}' WHERE product_id={$product_id}");
                         confirm($img_loc_query);
                         if($i == ($count-1)){  //When all the images are uploaded then only redirect
                           set_message("Product is added successfully!");
                           redirect("index.php?all_products");
                           die();
                         }

                       }else{
                         set_message("File was unable to move from temp location.");
                         redirect("../admin/index.php?add_new_exist_product");
                         die();
                       }

                     }  //Uploading the image

                     } //Image is real check end
                     else {
                       set_message("File is not an image.");
                       redirect("../admin/index.php?add_new_exist_product");
                       die();
                       }
                  }   //Image already exist else end
             }  //File successfully uploaded check end

         }  //For loop end



     } //All fields are filled check end
     else{
       set_message("All fields are required");
       redirect("../admin/index.php?add_new_exist_product");
       die();
     }
  } //Form submitted or not check end
}


//Function to display all products in admin dashboard

function display_all_products_in_admin(){

    $i=1;
    $fetch_products_query = query("SELECT * FROM products");
    confirm($fetch_products_query);

    //IF no product found
    if(rows($fetch_products_query) == '0'){
      $_SESSION['products_count'] = 0;
    }else{  //If products found
      if(isset($_SESSION['products_count'])){
        unset($_SESSION['products_count']);
      }
      while($products_row = fetch_array($fetch_products_query)){ //While start

        $product_id = $products_row['product_id'];
        $title = $products_row['product_title'];
        $cat_id = $products_row['product_category_id'];
        $brand_id = $products_row['brand_id'];
        $original_price = $products_row['product_original_price'];
        $offer_price = $products_row['product_price'];
        $short_desc = $products_row['product_short_description'];
        $image = $products_row['product_image_1'];

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


        $product_color_query = query("SELECT * FROM product_color WHERE product_id = {$product_id}");
        confirm($product_color_query);
        //More than one color of item is possible
        while($product_color_row = fetch_array($product_color_query)){  //Color while loop
          $product_color = $product_color_row['product_color_name'];
          $color_id = $product_color_row['product_color_id'];


          $product_size_query = query("SELECT * FROM product_size WHERE product_color_id = {$color_id}");
          confirm($product_size_query);
          //More than one size of item is possible
          while($product_size_row = fetch_array($product_size_query)){  //Size while loop

            $product_size = $product_size_row['product_size_name'];
            $size_id = $product_size_row['product_size_id'];
            $size_qty = $product_size_row['product_size_qty'];
            $product_table_tr = <<< DELIMETER
            <tr class="tbody_tr">
              <td data-th="S No. " class="td-center">{$i}</td>
              <td data-th="Title: ">{$title}</td>
              <td data-th="" class="td-center"><img class="img-responsive" src="{$image}" alt="product image"></td>
              <td data-th="Description: ">{$short_desc}</td>
              <td data-th="Category: " class="td-center">{$category_name}</td>
              <td data-th="Brand: " class="td-center">{$brand_name}</td>
              <td data-th="Color: " class="td-center" data-product-color-id="{$color_id}">{$product_color}</td>
              <td data-th="Size: " class="td-center" data-product-size-id="{$size_id}">{$product_size}</td>
              <td data-th="Original Price" class="td-center">{$original_price}</td>
              <td data-th="Offer Price" class="td-center">{$offer_price}</td>
              <td data-th="Quantity" class="td-center">{$size_qty}</td>
              <td data-th="" colspan="2" class="setting_icon_mobile">
                <a href="index.php?edit_product&ids={$product_id}_{$color_id}_{$size_id}" class="btn btn-warning btn-sm edit_product_btn"><i class="fa fa-pencil"></i></a>
                <button type="button" class="btn btn-danger btn-sm delete_product_btn" data-product-id="{$product_id}_{$color_id}_{$size_id}_{$size_qty}"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>
DELIMETER;
            echo $product_table_tr;
            ++$i;

          } //Size while loop end

        } //Color while loop end

      } //While end
    } //If products found else end

}

//Function to edit product in admin dashboard

function edit_product_in_admin(){

}

?>
