<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>


<!--header ENDS-->

<?php
if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
  redirect("ombre.php");
  die();
}
?>

<div class="container">     <!-- main container start -->

  <h2 class="text-center bg-danger text-danger"><?php display_message();?></h2>

  <h1 class="well">Registration Form</h1>
	<div class="col-lg-12 well">

	   <div class="row">   <!-- row start-->

				<form id="regform" autocomplete="off" onsubmit="return validateForm()" method="POST" action="resources/register_script.php">
					<div class="col-sm-12">

						<div class="row">
							<div class="col-sm-4 form-group">
								<label for="fname">First Name*</label>
								<input type="text" placeholder="Enter First Name Here.." class="form-control" id="fname" name="fname">
							</div>
							<div class="col-sm-4 form-group">
								<label for="lname">Last Name*</label>
								<input type="text" placeholder="Enter Last Name Here.." class="form-control"  id="lname" name="lname">
							</div>
              <div class="col-sm-4 form-group">
                <label for="username">Username*</label>
                <input type="text" placeholder="Enter Username Here.." class="form-control" name="username" id="username">
              </div>
						</div>

						<div class="form-group">
							<label for="address">Address*</label>
							<textarea placeholder="Enter Address Here.." rows="3" class="form-control" name="address" id="address"></textarea>
						</div>

						<div class="row">
							<div class="col-sm-4 form-group">
								<label for="city">City*</label>
								<input type="text" placeholder="Enter City Name Here.." class="form-control" id="city" name="city">
							</div>
							<div class="col-sm-4 form-group">
								<label for="state">State*</label>
								<input type="text" placeholder="Enter State Name Here.." class="form-control" id="state" name="state">
							</div>
							<div class="col-sm-4 form-group">
								<label for="zip">Zip*</label>
								<input type="text" placeholder="Enter Zip Code Here.." class="form-control" name="zip" id="zip">
							</div>
						</div>

            <div class="row">
    					<div class="col-sm-12 form-group numberdiv">
    						<label for="number">Phone Number*</label>
    						<input type="text" placeholder="Enter Phone Number Here.." class="form-control" id="number" name="number">
                <p id="OTPGenFail" class="hide text-danger bg-danger"></p>
                <button type="button" class="btn btn-info gen_otp_btn" title="Generate OTP" disabled="disabled">Generate OTP</button>
              </div>
              <div class="col-sm-12 form-group hide otpdiv">
    						<label for="otp">OTP</label>
    						<input type="text" placeholder="Enter OTP Here.." class="form-control" id="otp" name="otp">
                <p id="invalidOTPmsg" class="hide"></p>
                <button type="button" class="btn btn-info verify_otp_btn hide" title="Verify OTP">Verify OTP</button>
                <button type="button" class="btn btn-info resend_otp_btn hide" title="Resend OTP">Resend OTP</button>
              </div>
              <div class="col-sm-12 form-group hide otpSuccessMsg">
                <label class="text-success">Phone number verfied!</label>
              </div>
            </div>

					<div class="form-group">
						<label for="email">Email Address*</label>
						<input type="email" placeholder="Enter Email Address Here.." class="form-control" id="email" name="email">
					</div>
          <div class="form-group">
            <label for="cnfemail">Confirm Email Address*</label>
            <input type="email" placeholder="Confirm Email Address Here.." class="form-control" id="cnfemail" name="cnfemail">
          </div>

          <div class="form-group">
            <label for="password">Password*</label>
            <input type="password" placeholder="Enter Password Here.." class="form-control" id="password" name="password">
          </div>
          <div class="form-group">
            <label for="cnfpassword">Confirm Password*</label>
            <input type="password" placeholder="Confirm Password Here.." class="form-control" id="cnfpassword" name="cnfpassword">
          </div>

          <div class="form-group">
            <label>
              <input type="checkbox" name="agree" id="agree"/>
              I agree to Terms and Conditions
            </label>
            <br/>
          </div>

        </div>
					<button type="submit" class="btn btn-lg btn-info submit-btn" title="Please agree to terms and conditions" disabled="disabled">Register</button>
          <p class="note"><b>Note: </b>Fields mark with * are required</p>
				</form>
        <p style="margin-left:15px;">Already have an account? <a class="btn btn-primary btn-xs" href="login.php">Log in</a></p>
			</div>   <!-- row ends-->

	</div>

</div>    <!-- main container ends -->



<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>
<script src="bootstrap/dist/js/reg_form_validation.js"></script>
</body>
</html>
