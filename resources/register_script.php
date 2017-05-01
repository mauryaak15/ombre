<?php require_once("config.php") ?>
<?php

if(
  isset($_POST['fname'])&&
  isset($_POST['lname'])&&
  isset($_POST['username'])&&
  isset($_POST['address'])&&
  isset($_POST['city'])&&
  isset($_POST['state'])&&
  isset($_POST['zip'])&&
  isset($_POST['number'])&&
  isset($_POST['email'])&&
  isset($_POST['cnfemail'])&&
  isset($_POST['password'])&&
  isset($_POST['cnfemail'])
){
    $fname = escape_string($_POST['fname']);
    $lname = escape_string($_POST['lname']);
    $username = escape_string($_POST['username']);
    $address = escape_string($_POST['address']);
    $city = escape_string($_POST['city']);
    $state = escape_string($_POST['state']);
    $zip = escape_string($_POST['zip']);
    $number = escape_string($_POST['number']);
    $email = escape_string($_POST['email']);
    $cnfemail = escape_string($_POST['cnfemail']);
    $password = escape_string($_POST['password']);
    $cnfpassword = escape_string($_POST['cnfpassword']);

    if(
      $fname != ""&&
      $lname != ""&&
      $username != ""&&
      $address != ""&&
      $city != ""&&
      $state != ""&&
      $zip != ""&&
      $number != ""&&
      $email != ""&&
      $cnfemail != ""&&
      $password != ""&&
      $cnfpassword !=""

    ){

        $numberregexp = "/^[^0-6][0-9\-_]{0,10}$/";  //Regexp for mobile number

        if($password == $cnfpassword && $email == $cnfemail){

          if(preg_match($numberregexp,$number) AND strlen($number) == 10){

              $addregexp = "/^[a-zA-Z_ ]*$/";    //Regexp for state and city
              $zipregexp = "/^[0-9\-_]{6}$/";  //Regexp for zipcode
              $emailregexp = "/^[a-z][a-zA-Z0-9_]*(\.[a-zA-Z][a-zA-Z0-9_]*)?@[a-z][a-zA-Z-0-9]*\.[a-z]+(\.[a-z]+)?$/";   //Regexp for email
              $passregexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/";   //Regexp for password

              //Check number is verified or not
              if(checkStatus($number) != "NUMBER IS VERIFIED"){
                set_message("Number is not verified!");
                redirect("../register.php");
                die();
              }
              //Username Availability check
              $query_username = query("SELECT username FROM users WHERE username = '{$username}'");
              confirm($query_username);
              if(rows($query_username) != 0){
                set_message("Username ".$username." already registered");
                redirect("../register.php");
                die();
              }
              //Phone number Availabilty check
              $query_number = query("SELECT phone FROM users WHERE phone = {$number}");
              confirm($query_number);
              if(rows($query_number) != 0){
                set_message("Phone number ".$number." already registered");
                redirect("../register.php");
                die();
              }
              if(!preg_match($emailregexp,$email)){
                set_message("Please enter valid email address");
                redirect("../register.php");
                die();
              }
              //Email Availabilty check
              $query_email = query("SELECT email FROM users WHERE email = '{$email}'");
              confirm($query_email);
              if(rows($query_email) != 0){
                set_message("Email ".$email." already registered");
                redirect("../register.php");
                die();
              }
              if(!preg_match($addregexp,$city)){
                set_message("City should contain only alphabets");
                redirect("../register.php");
                die();
              }
              if(!preg_match($addregexp,$state)){
                set_message("State should contain only alphabets");
                redirect("../register.php");
                die();
              }
              if(!preg_match($zipregexp,$zip)){
                set_message("Zipcode should contain only digits (6 digits)");
                redirect("../register.php");
                die();
              }
              if(!preg_match($passregexp,$password)){
                set_message("Password must conatin lowercase and uppercase alphabets,numbers, special characters and minimum of 8 characters");
                redirect("../register.php");
                die();
              }

              //Insert details in users table
              $query_user_table = query("INSERT INTO users (first_name, last_name, username, email, password, phone) VALUES('{$fname}','{$lname}','{$username}','{$email}','{$password}',{$number})");
              confirm($query_user_table);

              //Fetching user_id from users table
              $query_user_id = query("SELECT user_id FROM users WHERE username = '{$username}'");
              confirm($query_user_id);
              $row_user_id = fetch_array($query_user_id);
              $user_id = $row_user_id['user_id'];

              //Insert details in address table
              $query_address_table = query("INSERT INTO address (user_id, address, state, city, zipcode, phone) VALUES({$user_id},'{$address}','{$state}','{$city}',{$zip},{$number})");
              confirm($query_address_table);

              /*//Fetching address_id from address table
              $query_address_id = query("SELECT address_id FROM address WHERE user_id = {$user_id}");
              confirm($query_address_id);
              $row_address_id = fetch_array($query_address_id);
              $address_id = $row_address_id['address_id'];

              //update address_id in users table
              $query_update_address_id = query("UPDATE users SET address_id = {$address_id} WHERE user_id = {$user_id}");
              confirm($query_update_address_id);*/
              set_message("Registration Successfull! Please Log in");
              redirect("../login.php");
              die();

          }else{
            set_message("Please enter a valid number");
            redirect("../register.php");
            die();
          }

        }else{
          redirect("../register.php");
          set_message("Password or Email didn't matched in both fields");
          die();
        }

    }else{
      redirect("../register.php");
      set_message("All fields are required!");
      die();
    }

}











?>
