<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
?>
<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>


<!--header ENDS-->

<?php
if(!isset($_SESSION['user_id'])){
  redirect("login.php");
  die();
}else{
  $user_id = $_SESSION['user_id'];
}

//To check if user has any pre saved addresses or not
$address_query = query("SELECT * FROM address WHERE user_id = {$user_id}");
confirm($address_query);
if(rows($address_query)== '0'){
  $address_found = '1';
}else{
  $address_found = '0';
}
?>


<div class='container'>     <!--Container start-->
    <div class='row'>     <!--Row start-->
        <div class='col-md-12'>     <!--main column start-->
          <h2 class="text-danger bg-danger text-center"><?php display_message();?></h2>
            <div id='mainContentWrapper'>     <!--main content wrapper start-->
                <div class="col-md-8 col-md-offset-2">    <!--col-md-8 start-->
                    <h2 class="text-center well">
                        Review Your Order &amp; Complete Checkout
                    </h2>
                    <hr/>
                    <a href="ombre.php" class="btn btn-info btn-block">Add More Products</a>
                    <a href="cart-items.php" class="btn btn-danger btn-block">Back to cart</a>
                    <hr/ style="margin-top: 10px;">
                    <div class="shopping_cart">     <!--shopping cart div start-->
                        <form class="form-horizontal" role="form" action="resources\paytm\process_payment.php" method="POST" id="payment-form" onsubmit="return validateCheckoutForm()">
                              <div class="panel-group" id="accordion">    <!--panel group start-->
                                  <div class="panel panel-default">     <!--1st panel start-->

                                      <div class="panel-heading">
                                          <h4 class="panel-title">
                                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                Review Your Order
                                              </a>
                                          </h4>
                                      </div>

                                      <div id="collapseOne" class="panel-collapse collapse in">     <!--collapseOne start-->
                                          <div class="panel-body">    <!--2nd Panel body start-->
                                              <div class="items">   <!--items start-->

                                                <?php display_products_in_checkout();
                                                if(isset($_SESSION['checkout_total_items'])){
                                                  if($_SESSION['checkout_total_items'] == 0){
                                                    set_message('Please add some items in your cart!');
                                                    redirect("cart-items.php");
                                                    die();
                                                  }
                                                }
                                                ?>

                                                  <div class="col-md-9">
                                                      <table class="table table-striped table-responsive text-right table-bordered">
                                                          <tr>
                                                              <th colspan="3">
                                                                  <h4>PRICE DETAILS</h4>
                                                                </th>
                                                          </tr>
                                                          <tr>
                                                              <th>Price(<?php
                                                              if(isset($_SESSION['checkout_total_items'])){
                                                                if($_SESSION['checkout_total_items'] == 1){
                                                                echo $_SESSION['checkout_total_items']." item";
                                                              }else{
                                                                echo $_SESSION['checkout_total_items']." items";
                                                              }
                                                            }
                                                              ?>)</th>
                                                              <td>Rs. <?php
                                                              if(isset($_SESSION['checkout_total'])){
                                                                echo $_SESSION['checkout_total'];
                                                              }
                                                              ?></td>
                                                          </tr>
                                                          <tr>
                                                              <th>Delivery</th>
                                                              <td class="text-success">Free</td>
                                                          </tr>

                                                          <tr>
                                                            <th>Amount Payable</th>
                                                            <th class="text-right">Rs. <?php
                                                            if(isset($_SESSION['checkout_total'])){
                                                              echo $_SESSION['checkout_total'];
                                                            }
                                                            ?></th>
                                                          </tr>
                                                        </table>
                                                      </div>


                                              </div>    <!--items end-->
                                            </div>    <!-- 1st Panel body end-->

                                            <div class="panel-footer panelFooterOne">
                                              <button
                                                      data-toggle="collapse"
                                                      data-parent="#accordion"
                                                      data-target="#collapseTwo"
                                                      type="button"
                                                      class=" btn btn-success btn-block text-center"
                                                      >
                                                    Continue to Billing Information»
                                                </button>
                                            </div>

                                      </div>    <!--collapseOne end-->
                                  </div>    <!--1st panel end-->

                              <div class="panel panel-default">     <!--2nd panel start-->

                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                            Contact and Billing Information
                                            </a>
                                      </h4>
                                  </div>

                                  <div id="collapseTwo" class="panel-collapse collapse">    <!-- collapseTwo start -->
                                      <div class="panel-body">    <!-- 2nd panel body start -->

                                        <div class="items">
                                          <div class="col-md-12">
                                            <div class="address_not_found_div hide">
                                              <h4 class="well text-primary">Sorry you don't have any address saved!</h4>
                                            </div>
                                                  <?php
                                                  get_user_address();
                                                  ?>
                                          </div>

                                          <div class="col-md-12 update_address_div row">
                                              <button class="btn btn-info add_address_btn" type="button"><span class="fa fa-plus"></span> Add New Address</button>
                                          </div>
                                        </div><!-- items end-->
                                      </div>  <!-- 2nd panel body end -->

                                      <div class="panel-footer">
                                        <button
                                                data-toggle="collapse"
                                                data-parent="#accordion"
                                                data-target="#collapseThree"
                                                type="button"
                                                class=" btn btn-success btn-block text-center"
                                                >
                                              Enter Payment Information »
                                          </button>
                                      </div>

                                  </div>    <!-- collapseTwo end -->

                              </div>    <!--2nd panel end-->

                              <div class="panel panel-default">   <!-- 3rd panel start-->

                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                              Payment Information
                                          </a>
                                      </h4>
                                  </div>

                                  <div id="collapseThree" class="panel-collapse collapse">    <!-- collapseThree start -->

                                      <div class="panel-body">    <!--3rd panel body start-->
                                        <div class="col-md-12 payment_div">

                                          <h5 class="well text-primary">Credit Card/Debit Card/NetBanking/Paytm Wallet/Cash On Delivery</h5>

                                          <div class="col-md-7 paytm_div">
                                            <lable for="paytm"><img src="resources/uploads/paytm.png" alt="pay with paytm" class="img-responsive paytm-img"></label>
                                            <input type="radio" class="" name="payment_option" value="pay_with_paytm" id="paytm">
                                          </div>

                                          <div class="col-md-5 cod_div">
                                            <label for="cod">Cash On Delivery</label>
                                            <input type="radio" class="" name="payment_option" value="cod" id="cod">
                                          </div>

                                        </div>
                                  </div>    <!--3rd panel body end-->

                                  <div class="panel-footer">
                                    <button
                                            type="submit"
                                            name="submit"
                                            class=" btn btn-success btn-block text-center"
                                            >
                                          Proceed »
                                      </button>
                                  </div>


                              </div>    <!-- collapseThree end -->
                      </div>  <!-- 3rd panel end-->

                  </div>    <!--panel group start-->
                </form>
              </div>    <!--shopping cart div end-->
            </div>    <!--col-md-8 end-->
        </div>    <!--main content wrapper end-->
    </div>    <!--main column end-->
  </div>    <!--Row end-->
</div>    <!--Container end-->


<!-- Modal 1 -->
<div id="errorModal" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-body bg-danger text-danger">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <strong><p id="error_text"></p></strong>
    </div>
  </div>
</div>
</div>

<!-- Modal 2 Edit address modal -->
<div id="editAddressModal" class="modal fade" role="dialog">
<div class="modal-dialog">    <!--  modal dialog start -->

  <!-- Modal content-->
  <div class="modal-content" style="background-color:#f6f6f6;"> <!-- modal content start -->

    <!--Modal Header-->
    <div class="modal-header">
      <h4 class="modal-title"></h4>
    </div>

    <div class="modal-body"> <!-- modal body start -->

      <form id="editAddressForm" autocomplete="off" method="post" onclick="return validateEditAddressForm()" action="ajax_user_address_checkout.php">

          <div class="row">
              <div class="col-sm-12 form-group">
  							<label for="address">Address*</label>
  							<textarea placeholder="Enter Address Here.." rows="3" class="form-control" name="address" id="address"></textarea>
  						</div>
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
    						<input type="text" placeholder="Can be same as registered mobile number.." class="form-control" id="number" name="number">
              </div>
            </div>
            <input type="text" hidden="hidden" name="" id="general_address_id">
            <button type="submit" class="btn btn-info" title=""><span class="fa"></span></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" title="Cancel"><span class="fa fa-remove"></span> Cancel</button>

      </form>
    </div>     <!-- modal body end -->
  </div>    <!-- modal content end -->
</div>    <!--  modal dialog end -->
</div>


<!--Modal 3 for error report of check out validation -->
<div id="validateErrorModal" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-body bg-danger text-danger">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <strong><p id="checkout_error_text"></p></strong>
    </div>
  </div>
</div>
</div>

<!-- Modal 4 for confirmation of 10 minutes warning -->

<!--<div id="confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <! Modal content>
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Attention</h4>
      </div>
      <div class="modal-body">
        You will given 10 minutes for completing this transaction after
        that this product will be displayed to other users also and product may or may not be available!
      </div>

      <!Modal Footer >
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirm-btn">Confirm</button>
        <button type="button" data-dismiss="modal" class="btn" id="cancel">Cancel</button>
      </div>
    </div>
  </div>
</div>-->
<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

<script>
var address_found = '<?php echo $address_found;?>';
</script>
<script src="bootstrap/dist/js/checkout.js"></script>
