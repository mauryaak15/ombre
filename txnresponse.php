<?php
/* Whole process
 ****************
 * When user is in progress of transaction lock the order products for 10 minutes by entering the record
 * of those products in product current available stock table and decrementing the product quantity for 10 minutes
 * if transaction is successfull then remove the entry of lock from product current available stock table
 * and dont't undo the decremented quantity else remove the lock and undo the decremented quantity
 */

/* Steps which have been performed here
 ******************************************
 * previous steps were performed on process_payment and product_info page
 * 3. Run the check_locked_products() function to ensure that products were releases if time is limit exceeded
 * 4. Check if user came within the time Limit
 * * 4 a). If yes and transacion is successfull then place the order and remove the entry from product_current_available_stock and empty the cart
 * * 4 b). If no and transacion is successfull then check if stock is available if yes then confirm the order and deduct the quantity from DB and empty the cart
 * * 4 c). If no and transaction is successfull but product is out of stock then display error and refund the money
 * * 4 d). If no and transaction is unsuccessfull then display error and do nothing
 * * 4 e). If yes and transaction is unsuccessfull then display error and remove the entry from product_current_available_stock and increment the quantity
 */


header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

require_once("resources/config.php");
require_once(TEMPLATE_FRONT.DS."header.php");

// following files need to be included
require_once("resources/paytm/lib/config_paytm.php");
require_once("resources/paytm/lib/encdec_paytm.php");
?>

<!--header ENDS-->

<div class="container">

<?php
if(!isset($_POST["CHECKSUMHASH"])){
  set_message("Invalid Request");
  redirect("ombre.php");
  die();
}

?>

<?php
$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

date_default_timezone_set('Asia/Kolkata');   //To ensure it display correct time
$last_time = $_SESSION['last_time'];
$current_time = strtotime(date("Y-m-d H:i:s"));
$elapsed_time = round(abs($current_time - $last_time)/60,0); //In minutes(/60)
$product_flag = []; //if product in not available after checkout then this flag will be set
$flag_no_order = 1; //IF transaction successfull and time limit exceeds and all the product in order placed are not avilable
$user_id = $_SESSION['user_id'];

if($isValidChecksum == "TRUE") {    //Checksum validation IF
	if ($_POST["STATUS"] == "TXN_SUCCESS") {   //Transaction failed check
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
    if(($_SESSION['order_id'] = $_POST['ORDERID']) AND ($_SESSION['checkout_total'] = $_POST['TXNAMOUNT'])){

        $order_id = $_SESSION['order_id'];
        $total_items = $_SESSION['checkout_total_items'];
        $user_id = $_SESSION['user_id'];
        $checkout_total = $_SESSION['checkout_total'];
        $address_choice = $_SESSION['address_choice'];

       //Fetching product ids and quantity from session

       //1st Foreach
       foreach ($_SESSION as $product_key => $product_value) {
           if(substr($product_key, 0, 8) == 'product_'){

               $product_key_length = strlen($product_key);
               $product_id = substr($product_key, 8, $product_key_length);

               $product_price_query = query("SELECT product_price FROM products WHERE product_id = {$product_id}");
               confirm($product_price_query);
               $product_price_row = fetch_array($product_price_query);
               $product_price = $product_price_row['product_price'];

                //Performing step no.3
                check_locked_products($product_id);

                  //2nd Foreach
                 foreach ($product_value as $color_key => $color_value) {
                   $color_key_length = strlen($color_key);
                   $color_id = substr($color_key, 14, $color_key_length);


                     //3rd Foreach
                     foreach ($color_value as $size_key => $size_value) {
                         $size_key_length = strlen($size_key);
                         $size_id = substr($size_key, 13, $size_key_length);

                         $product_size_qty_query = query("SELECT product_size_qty FROM product_size WHERE product_size_id = {$size_id}");
                         confirm($product_size_qty_query);
                         $product_size_qty_row = fetch_array($product_size_qty_query);
                         $product_size_qty = $product_size_qty_row['product_size_qty'];

                         //If time limit exceeds step 4.b) AND 4. c)
                         if($elapsed_time > '10'){

                           if($product_size_qty >= $size_value){  //Step 4. b)

                             //Flag set (there is/are item/s in order)
                             $flag_no_order = 0;

                             //Reducing Quantity of product
                             $dec_product_qty_query = query("UPDATE products SET product_qty = product_qty - {$size_value} WHERE product_id = {$product_id}");
                             confirm($dec_product_qty_query);

                             $dec_product_color_qty_query = query("UPDATE product_color SET product_color_qty = product_color_qty - {$size_value} WHERE product_color_id = {$color_id}");
                             confirm($dec_product_color_qty_query);

                             $dec_product_size_qty_query = query("UPDATE product_size SET product_size_qty = product_size_qty - {$size_value} WHERE product_size_id = {$size_id}");
                             confirm($dec_product_size_qty_query);

                             //Making entry in reports table
                             $report_table_entry_for_product_query = query("INSERT INTO reports (order_id,product_id,product_color_id,product_size_id,product_quantity,product_current_price) VALUES('{$order_id}',{$product_id},{$color_id},{$size_id},{$size_value},{$product_price})");
                             confirm($report_table_entry_for_product_query);

                             //Remove session of placed items or remove thar item from cart
                             unset($_SESSION['product_'.$product_id]['product_color_'.$color_id]['product_size_'.$size_id]);

                           }else{ //Step 4 .c)
                             $product_flag = array("{$product_id}_{$color_id}_{$size_id}"=>"Quantity not available");
                             //Reducing order quantity if that product is not available!
                             $total_items -= 1;
                             //Update checkout total
                             $st = $size_value*$product_price;
                             $checkout_total -= $st;

                           }

                         } //Time limit exceeds if end here

                         //If user came in time limit! Step 4 .a)
                         //if($elapsed_time <= '10'){
                          else{

                           //Flag set (there is/are item/s in order)
                           $flag_no_order = 0;
                           
                           //Remove entry from product current available stock
                           $delete_locked_product_entry_query = query("DELETE FROM product_current_available_stock WHERE product_id = {$product_id} AND product_color_id = {$color_id} AND product_size_id = {$size_id} AND user_id = {$user_id}");
                           confirm($delete_locked_product_entry_query);

                           //Make entry in reports table
                           $report_table_entry_for_product_query = query("INSERT INTO reports (order_id,product_id,product_color_id,product_size_id,product_quantity,product_current_price) VALUES('{$order_id}',{$product_id},{$color_id},{$size_id},{$size_value},{$product_price})");
                           confirm($report_table_entry_for_product_query);

                         }


                       } //3rd Foreach loop ends
                     } //2nd Foreach loop end
                   }  //If ends
                 }   //1st forech loop ends

                 //Place order if stock available (common for both step 4 a) b) c))

                 $currency = $_POST['CURRENCY'];
                 $txn_id = $_POST['TXNID'];
                 $bank_txn_id = $_POST['BANKTXNID'];
                 $status = $_POST['STATUS'];
                 $resp_code = $_POST['RESPCODE'];
                 $resp_msg = $_POST['RESPMSG'];
                 $txn_date = $_POST['TXNDATE'];
                 $gateway_name = $_POST['GATEWAYNAME'];
                 $bank_name = $_POST['BANKNAME'];
                 $payment_mode = $_POST['PAYMENTMODE'];

                  if($flag_no_order == 0){

                    //Make entry in orders table
                    $time = date('Y-m-d H:i:s');
                    $order_table_entry_query = query("INSERT INTO orders(order_id,user_id,order_amount,order_quantity,order_status,order_date_time,transaction_id,address_id,payment_method) VALUES('{$order_id}',{$user_id},{$checkout_total},{$total_items},'{$status}','{$time}','{$txn_id}',{$address_choice},'paytm')");
                    confirm($order_table_entry_query);

                    //Make entry in transaction_details table
                    $transaction_details_query = query("INSERT INTO transaction_details(txn_amount,currency,transaction_id,bank_txn_id,status,response_code,response_message,gateway_name,bank_name,payment_mode,checksumhash) VALUES({$checkout_total},'{$currency}','{$txn_id}','{$bank_txn_id}','{$status}',{$resp_code},'{$resp_msg}','{$gateway_name}','{$bank_name}','{$payment_mode}','{$paytmChecksum}')");
                    confirm($transaction_details_query);

                    //If some of the products are are not avilable in case of time limit exceeds and some are placed

                    if(count($product_flag) > 0){//Display message order confirmation with error that some products are not avilable and could not be placed as you have exceeded the time limit

                      echo '<div class="jumbotron" style="background-color:#5cb85c;color:#fff;">
                      <h1>Transcation successfull!</h1>
                      <p>Oder placed successfully.Some products are not avilable as you have exceeded the given time limit(10 minutes) therefore we are not able to process those items. Please try again later after sometime.
                      Your balance amount will be refunded to you, for further assistance please contact our customer care. Thank you!
                      </p>
                      <a href="orders.php" class="btn btn-primary">Go to orders</a>
                      </div>';

                      //Make entry in txn_success_order_not_placed (for refund reference)
                      $balance_amt = $_POST['TXNAMOUNT'] - $checkout_total;
                      $refund_entry_query = query("INSERT INTO txn_success_order_not_placed (user_id,txn_id,txn_amount,currency,bank_txn_id,gateway_name,bank_name) VALUES({$user_id},'{$txn_id}',{$balance_amt},'{$currency}',{$bank_txn_id},'{$gateway_name}','{$bank_name}')");
                      confirm($refund_entry_query);

                      //Remove session of placed items or remove that item from cart
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

                    }else if($elapsed_time <= '10'){ //Display message order confirmation

                      //Empty cart (Destroy product session)

                        //1st Foreach
                        foreach ($_SESSION as $product_key => $product_value) {

                          if(substr($product_key, 0, 8) == 'product_'){
                            unset($_SESSION[$product_key]);
                          }
                        } //1st Foreach end

                      echo '<div class="jumbotron" style="background-color:#5cb85c;color:#fff;">
                      <h1>Transcation successfull!</h1>
                      <p>Oder placed successfully. Thank you for shopping with us!</p>
                      <a href="orders.php" class="btn btn-primary">Go to orders</a>
                    </div>';
                    }

                  }else{ //If time limit exceeds and no product is available for order_placement


                    echo '<div class="jumbotron" style="background-color:#d9534f;color:#fff;">
                    <h1>Order could not be placed,Transaction successfull!</h1>
                    <p>Sorry we are not able to process your order, because you have exceeded the given time limit (10 minutes) and product is not avilable right now. Please try again later after sometime.
                    Your amount will be refunded to you, for further assistance please contact our customer care. Thank you!
                    </p>
                    <a href="ombre.php" class="btn btn-primary">Continue shopping</a>
                  </div>';

                  //Make entry in txn_success_order_not_placed (for refund reference)

                  $refund_entry_query = query("INSERT INTO txn_success_order_not_placed (user_id,txn_id,txn_amount,currency,bank_txn_id,gateway_name,bank_name) VALUES({$user_id},{$txn_id},{$checkout_total},{$currency},{$bank_txn_id},{$gateway_name},{$bank_name})");
                  confirm($refund_entry_query);

                  }


    }else{
      echo '<h1 class="bg-danger" style="color:#fff;">Transaction parameters are mismatched!</h1>';
    }

	}      //Transaction failed check
	else {
		echo '<div class="jumbotron" style="background-color:#d9534f;color:#fff;">
    <h1>Transcation Failed!</h1>
    <p>Sorry your order could not be placed.</p>
    <a href="ombre.php" class="btn btn-primary">Continue shopping</a>
  </div>';

    if($elapsed_time <= '10'){

      //Update(Increment) the product quantity
      $locked_product_check_query =  query("SELECT * FROM product_current_available_stock WHERE user_id = {$user_id}");
      confirm($locked_product_check_query);
      while($row = fetch_array($locked_product_check_query)){
        $locked_qty = $row['product_quantity'];
        $color_id = $row['product_color_id'];
        $size_id = $row['product_size_id'];
        $product_id = $row['product_id'];

        $update_product_qty_query = query("UPDATE products SET product_qty = product_qty + {$locked_qty} WHERE product_id = {$product_id}");
        confirm($update_product_qty_query);

        $update_product_color_qty_query = query("UPDATE product_color SET product_color_qty = product_color_qty + {$locked_qty} WHERE product_id = {$product_id} AND product_color_id = {$color_id}");
        confirm($update_product_color_qty_query);

        $update_product_size_qty_query = query("UPDATE product_size SET product_size_qty = product_size_qty + {$locked_qty} WHERE product_id = {$product_id} AND product_color_id = {$color_id} AND product_size_id = {$size_id}");
        confirm($update_product_size_qty_query);

      }
      //Remove entry from product current available stock
      $delete_locked_product_entry_query = query("DELETE FROM product_current_available_stock WHERE user_id = {$user_id}");
      confirm($delete_locked_product_entry_query);

    } //If return was within timelimit
    else{
      check_locked_products($product_id); //If timelimit exceeds automatically release the product
    }

	}  //Transaction failed else end here

}   //Checksum validation IF end
else {
	echo '<h1 class="bg-danger" style="color:#fff;">Checksum mismatched.</h1>';
}




?>


</div><!--container div end-->

<!-- FOOTER -->
<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

<!--Footer ends-->
