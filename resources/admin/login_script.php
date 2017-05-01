/*Log In Script For admin login*/

<?php require_once("../config.php") ?>
<?php
if(isset($_SESSION['admin_id'])&&!empty($_SESSION['admin_id'])){
  redirect("../../admin/index.php");
  die();
}else{
  if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = escape_string($_POST['username']);
    $password = escape_string($_POST['password']);
    $password = md5($password);
    if(!empty($username)&&!empty($password)){
      $query = query("SELECT admin_id FROM admin WHERE admin_username='{$username}' AND admin_pass='{$password}'");
      confirm($query);
      if(!rows($query)){
        set_message("Your username or password is incorrect");
        redirect("../templates/back/login.php");
        die();
      }else{
        while($row = fetch_array($query)){
          $admin_id = $row['admin_id'];
        }
        $_SESSION['admin_id'] = $admin_id;
        redirect("../../admin/index.php");
        die();
      }
    }else{
      set_message("Either username or password is empty");
      redirect("../templates/back/login.php");
      die();
    }
  }
}
?>
