<?php
require_once("resources/config.php");
//delete address in checkout using ajax

if(isset($_POST['delete_address_id'])&&$_POST['delete_address_id'] != ""){
  $address_id = escape_string($_POST['delete_address_id']);
  $user_id = escape_string($_SESSION['user_id']);
  $query = query("SELECT * FROM address WHERE user_id = {$user_id} AND address_id = {$address_id}");
  confirm($query);
  if(rows($query) == '0'){
    echo "Something went wrong!";
  }else{
    $query_delete = query("DELETE FROM address WHERE user_id = {$user_id} AND address_id = {$address_id}");
    confirm("$query_delete");
    echo '1';
  }
}

//edit address in checkout using ajax

if(isset($_POST['edit_address_id'])&&$_POST['edit_address_id'] != ""){
  $address_id = escape_string($_POST['edit_address_id']);
  $user_id = escape_string($_SESSION['user_id']);
  $address_info = array();
  $query = query("SELECT * FROM address WHERE user_id = {$user_id} AND address_id = {$address_id}");
  confirm($query);
  if(rows($query) == '0'){
    echo "Something went wrong!";
  }else{
    while($row = fetch_array($query)){
      $address_info['address'] = $row['address'];
      $address_info['state'] = $row['state'];
      $address_info['city'] = $row['city'];
      $address_info['zipcode'] = $row['zipcode'];
      $address_info['phone'] = $row['phone'];
    }
    echo json_encode($address_info);
  }
}

//Update the address in database
 if(isset($_POST['address'])&&
    isset($_POST['state'])&&
    isset($_POST['city'])&&
    isset($_POST['zip'])&&
    isset($_POST['number'])&&
    isset($_POST['update_address_id'])
 ){
   $address = escape_string($_POST['address']);
   $state = escape_string($_POST['state']);
   $city = escape_string($_POST['city']);
   $zip = escape_string($_POST['zip']);
   $number = escape_string($_POST['number']);
   $address_id = escape_string($_POST['update_address_id']);
   $user_id = $_SESSION['user_id'];
   $query = query("SELECT * FROM address WHERE user_id = {$user_id} AND address_id = {$address_id}");
   confirm($query);
   if(rows($query) == '0'){
     set_message("Something went wrong!");
     redirect("checkout.php");
     die();
   }else{
     $query_update = query("UPDATE address SET address = '{$address}', state = '{$state}', city = '{$city}', zipcode = {$zip}, phone = {$number} WHERE address_id = {$address_id} AND user_id = {$user_id} ");
     confirm($query_update);
     set_message("Address updated successfully!");
     redirect("checkout.php");
     die();
   }
 }


 //Add new address in database
  if(isset($_POST['address'])&&
     isset($_POST['state'])&&
     isset($_POST['city'])&&
     isset($_POST['zip'])&&
     isset($_POST['number'])&&
     isset($_POST['add_address_id'])
  ){
    $address = escape_string($_POST['address']);
    $state = escape_string($_POST['state']);
    $city = escape_string($_POST['city']);
    $zip = escape_string($_POST['zip']);
    $number = escape_string($_POST['number']);
    $user_id = $_SESSION['user_id'];
    if(
      $address != ""&&
      $city != ""&&
      $state != ""&&
      $zip != ""&&
      $number != ""
    ){    //If empty test start
        $addregexp = "/^[a-zA-Z_ ]*$/";    //Regexp for state and city
        $zipregexp = "/^[0-9\-_]{6}$/";  //Regexp for zipcode
        $numberregexp = "/^[^0-6][0-9\-_]{0,10}$/";  //Regexp for mobile number

        if(!preg_match($addregexp,$city)){
          set_message("City should contain only alphabets");
          redirect("checkout.php");
          die();
        }
        if(!preg_match($addregexp,$state)){
          set_message("State should contain only alphabets");
          redirect("checkout.php");
          die();
        }
        if(!preg_match($zipregexp,$zip)){
          set_message("Zipcode should contain only digits (6 digits)");
          redirect("checkout.php");
          die();
        }
        if(!preg_match($numberregexp,$number) OR strlen($number) != 10){
          set_message("Enter a valid phone number!");
          redirect("checkout.php");
          die();
        }

        $query = query("INSERT INTO address (user_id, address, state, city, zipcode, phone) VALUES({$user_id},'{$address}','{$state}','{$city}',{$zip},{$number})");
        confirm($query);
        set_message("Address added successfully!");
        redirect("checkout.php");
        die();

      //If empty test end
    }else{
      set_message("All fields are required!");
      redirect("checkout.php");
      die();
    }

  }

?>
