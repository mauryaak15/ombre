<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>

<!--header ENDS-->

<?php
if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
  redirect("ombre.php");
  die();
}
?>



<div class="container">     <!--Container start -->

  <header>
          <h2 class="text-center bg-danger text-danger animated slideInLeft"><?php display_message();?></h2>

          <?php
          if( isset($_SERVER['HTTP_REFERER'])){
            $url = $_SERVER['HTTP_REFERER'];
          }else{
            $url = "../ombre.php";
          }
          ?>

          <div class="col-sm-4 col-sm-offset-4 well">
              <h1 class="text-center">Login</h1>
              <form class="" action="resources/login_script.php" method="post" enctype="multipart/form-data">
                  <div class="input-group form-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" name="username" id="username" class="form-control" placeholder="username">
                  </div>
                   <div class="input-group form-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" name="password" class="form-control" id="password" placeholder="password">
                  </div>

                  <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login" >
                  </div>
                  <input type="text" hidden name="url" value="<?php echo $url?>">
              </form>
              <p class="text-center">
                Don't have an account?
                <br>
                <br>
                <a  class="btn btn-primary" href="register.php" title="Register" >Register</a>
              </p>
          </div>
  </header>

</div>     <!--Container end -->

  <!-- FOOTER -->
	<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

  </body>
</html>
