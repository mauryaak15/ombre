<div class="row scrollnav">  <!-- row start-->
    <nav class="navbar navbar-inverse custom-navbar-fixed-top" id="fixednav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#tnavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button class="navbar-toggle" type="button" onclick="openNav();" style="float: left; margin-left: 10px;">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="ombre.php">Ombre</a>
            </div>
            <div class="collapse navbar-collapse" id="tnavbar">
                <ul class="nav navbar-nav">
                    <li><a href="ombre.php">Home</a></li>
                    <li><a href="shop.php">Products</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact Info</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="cart-items.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge cart-count"></span></a></li>
                    <li id="log_in_menu"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                    <li class="dropdown" id="log_in_menu_show">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php
                                                                                                            if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){echo get_user_name($_SESSION['user_id']);}?>
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li>
                              <a href="orders.php"><i class="fa fa-cart-arrow-down"></i> My orders</a>
                          </li>
                          <li class="divider"></li>
                          <li>
                              <a href="profile.php"><i class="fa fa-user"></i> My profile</a>
                          </li>
                          <li class="divider"></li>
                          <li>
                              <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                          </li>
                      </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>    <!-- row end-->
