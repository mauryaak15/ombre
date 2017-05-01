<?php require_once('../config.php');?>
<?php
if(isset($_POST['submit'])){      //form submission check

    if(isset($_POST['address_choice'])){    //If address selected

        if(isset($_POST['payment_option'])){    //If payment selected

          $payment_option = $_POST['payment_option'];   //Mode of payment either COD or PAYTM
          $address_choice = $_POST['address_choice'];   //Address id of selected address of user
          $user_id = $_SESSION['user_id'];
          $order_total = $_SESSION['checkout_total'];     //Total amount of order
          $total_items = $_SESSION['checkout_total_items'];     //No. of items in order
          $order_id = 'ORDER_'.$user_id.'_'.time().'_'.mt_rand(10000,99999999);  //unique order id generation
          $_SESSION['order_id'] = $order_id;
          $_SESSION['address_choice'] = $address_choice;

          //check if payment is COD or PAYTM

          if($payment_option == "cod"){
            //If mode of payment is COD


          }else if($payment_option == "pay_with_paytm"){
            /*If mode of payment is paytm
            below form will be submitted to pgRedirect.php*/

            /* Whole process
             ****************
             * When user is in progress of transaction lock the order products for 10 minutes by entering the record
             * of those products in product current available stock table and decrementing the product quantity for 10 minutes
             * if transaction is successfull then remove the entry of lock from product current available stock table
             * and dont't undo the decremented quantity else remove the lock and undo the decremented quantity
             */

            /* Steps which have been performed here
             ******************************************
             * 1. Make entry in product current available stock table
             * 2. Decrement the products quantity
             * Next steps will be on call back page and product_info page
             */

             //Fetching product ids and quantity from session

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


                               //1. Entry in lock table
                               date_default_timezone_set('Asia/Kolkata');   //To ensure it display correct time
                               $current_time = date('Y-m-d H:i:s');
                               $lock_table_query = query("INSERT INTO product_current_available_stock (user_id, product_id, product_color_id, product_size_id, product_quantity,`timestamp`) VALUES({$user_id}, {$product_id}, {$color_id}, {$size_id}, {$size_value},'{$current_time}')");
                               confirm($lock_table_query);

                               //2. Decrementing product quantity (Temporary)

                              $dec_product_qty_query = query("UPDATE products SET product_qty = product_qty - {$size_value} WHERE product_id = {$product_id}");
                              confirm($dec_product_qty_query);

                              $dec_product_color_qty_query = query("UPDATE product_color SET product_color_qty = product_color_qty - {$size_value} WHERE product_color_id = {$color_id}");
                              confirm($dec_product_color_qty_query);

                              $dec_product_size_qty_query = query("UPDATE product_size SET product_size_qty = product_size_qty - {$size_value} WHERE product_size_id = {$size_id}");
                              confirm($dec_product_size_qty_query);

                              //Record the time at which transaction start and place in Session
                              date_default_timezone_set('Asia/Kolkata');   //To ensure it display correct time
                              $_SESSION['last_time'] = strtotime(date("Y-m-d H:i:s"));

                             } //3rd Foreach loop ends
                           } //2nd Foreach loop end
                         }  //If ends
                       }   //1st forech loop ends



          }else{    //If sources changes and value of radio button got changed
            set_message('Something went wrong!');
            redirect($_SERVER['HTTP_REFERER']);
            die();
          }


        }else{    //else of payment selection check
          set_message('Please select payment option');
          redirect($_SERVER['HTTP_REFERER']);
          die();
        }
    }else{    //else of address selection check
      set_message('Please select address');
      redirect($_SERVER['HTTP_REFERER']);
      die();

    }
}else{    //form submission check end
    set_message('Invalid Request!');

    if(isset($_SERVER['HTTP_REFERER'])){
      redirect($_SERVER['HTTP_REFERER']);
      die();
    }else{
      redirect('../../ombre.php');
      die();
    }
}

?>
<!--auto form submission when payment mode is paytm-->
<form action="pgRedirect.php" method="post" name="form">
<input type="text" hidden="hidden" value="<?php echo $order_id;?>" name="ORDER_ID">
<input type="text" hidden="hidden" value="<?php echo $order_total;?>" name="TXN_AMOUNT">
<input type="text" hidden="hidden" value="<?php echo $user_id;?>" name="CUST_ID">
</form>

<script>
var payment_option = "<?php echo $payment_option;?>"
if(payment_option == "pay_with_paytm"){
  document.form.submit();
}
</script>
