<?php
require_once("resources/config.php");

if(isset($_POST['username'])&&$_POST['username'] != "" ){
  $username = escape_string($_POST['username']);
  $query = query("SELECT username FROM users WHERE username = '{$username}'");
  confirm($query);
  if(rows($query) == 0){
    echo '1';
  }else{
    echo '0';
  }

}

if(isset($_POST['number'])&&$_POST['number'] != ""){
  $number = escape_string($_POST['number']);
  $query = query("SELECT phone FROM address WHERE phone = {$number}");
  confirm($query);
  if(rows($query) == 0){
    echo '1';
  }else{
    echo '0';
  }

}

if(isset($_POST['email'])&&$_POST['email'] != ""){
  $email = escape_string($_POST['email']);
  $query = query("SELECT email FROM users WHERE email = '{$email}'");
  confirm($query);
  if(rows($query) == 0){
    echo '1';
  }else{
    echo '0';
  }

}

?>
