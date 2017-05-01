<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../../bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../../../font-awesome-4.6.3\css\font-awesome.min.css" type="text/css" />
    <title>Ombre - Admin</title>

</head>
<!--header ENDS-->

<body>

<?php
include_once("../../config.php");
if(isset($_SESSION['admin_id'])&&!empty($_SESSION['admin_id'])){
  redirect("../../../admin/index.php");
  die();
}
?>



<div class="container">     <!--Container start -->

  <header>
          <h2 class="text-center bg-danger text-danger"><?php display_message();?></h2>


          <div class="col-sm-4 col-sm-offset-4 well">
              <h1 class="text-center">Admin Login</h1>
              <form class="" action="../../admin/login_script.php" method="post" enctype="multipart/form-data">
                  <div class="form-group input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" name="username" id="username" class="form-control" placeholder="username">
                  </div>
                   <div class="form-group input-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" name="password" class="form-control" id="password" placeholder="password">
                  </div>

                  <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login" >
                  </div>
              </form>
          </div>
  </header>

</div>     <!--Container end -->

  </body>
</html>
