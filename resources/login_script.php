/*Log In Script For login.php*/

<?php require_once("config.php") ?>
<?php
if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
  redirect("..".DS."ombre.php");
  die();
}else{
  if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = escape_string($_POST['username']);
    $password = escape_string($_POST['password']);
    $url = escape_string($_POST['url']);
    if(!empty($username)&&!empty($password)){
      $query = query("SELECT user_id FROM users WHERE username='{$username}' AND password='{$password}'");
      confirm($query);
      if(!rows($query)){
        set_message("Your username or password is incorrect");
        redirect("..".DS."login.php");
        die();
      }else{
        while($row = fetch_array($query)){
          $user_id = $row['user_id'];
        }
        $_SESSION['user_id'] = $user_id;
        fetch_cart_items($user_id);  //if items are present in cart before(database)
        redirect($url);
        die();
      }
    }else{
      set_message("Either username or password is empty");
      redirect("..".DS."login.php");
      die();
    }
  }
}
?>
