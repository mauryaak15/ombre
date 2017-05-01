<?php
require_once('resources/config.php');
if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
  save_session_cart_after_login($user_id);
  session_destroy();
  redirect($_SERVER['HTTP_REFERER']);
  die();
}else{
  redirect('ombre.php');
  die();
}
?>
