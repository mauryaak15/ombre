<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>

<?php send_message();?>

<!--header ENDS-->

<div class="container">			<!--Container start -->
	<h1>Contact Address</h1><br>
	<h1 class="text-center text-danger bg-danger"><?php display_message(); ?></h1>
	<div class="row text-center"> 	<!-- row start here -->
    <div class="col-md-12 all-padding-zero">			<!-- main column start-->

        <div class="col-sm-3 col-xs-6 col-md-3 first-box">
            <h1><span class="glyphicon glyphicon-earphone"></span></h1>
            <h3>Phone</h3>
            <p>+91-98112141</p><br>
        </div>

        <div class="col-sm-3 col-xs-6 col-md-3 second-box">
            <h1><span class="glyphicon glyphicon-home"></span></h1>
            <h3>Location</h3>
            <p>77 Sector28</p><br>
        </div>

        <div class="col-sm-3 col-xs-6 col-md-3 third-box">
            <h1><span class="glyphicon glyphicon-send"></span></h1>
            <h3>E-mail</h3>
            <p>info@ombre.com</p><br>
        </div>

        <div class="col-sm-3 col-xs-6 col-md-3 fourth-box">
        	<h1><span class="glyphicon glyphicon-leaf"></span></h1>
            <h3>Web</h3>
            <p>www.ombre.com</p><br>
        </div>

      </div>		<!-- main column ends-->
	</div>			<!-- row ends here -->


<!-- Form begins -->
	<form method="post" enctype="multipart/form-data">
    <div class="row all-padding-zero">			<!-- row start -->
        <div class="col-md-12 well">		<!-- main column start-->

        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" name="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <select class="form-control" name="subject">
                    <option selected value="na">Choose One:</option>
                    <option value="inquiry">General Inquiry</option>
                    <option value="suggestions">Suggestions</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" name="message" rows="11" placeholder="Enter Message"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary pull-right" type="submit">Send</button>
            </div>
        </div>

        </div>		<!-- main column ends-->
    </div>	<!-- row ends -->
	</form>
</div>		<!--Container ends -->
<br>


  <!-- FOOTER -->
	<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

</body>
</html>
