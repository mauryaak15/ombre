<?php require_once("resources/config.php"); ?>
<?php require_once("resources/cart.php"); ?>
<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>

<!--header ENDS-->

<!-- Cart table start -->

<div class="container-fluid">
  <div class="col-md-12"> <!-- Main column start -->
    <div class="row">   <!-- Main row start-->
      <h1 class="cart_empty_message text-center text-info"><?php display_message();?></h1>
      <center><a href="ombre.php" class="btn btn-success btn-lg cont_shopping_btn hide">Shop Now!</a></center>
    	<table id="cart" class="table table-hover table-condensed">
        				<thead>
    						<tr>

    							<th class="product-th">Product Name</th>
                  <th class="brand-th">Brand</th>
                  <th class="color-th">Color</th>
                  <th class="size-th">Size</th>
    							<th class="price-th">Price</th>
                  <th class="delivery-th">Delivery</th>
    							<th class="text-center qty-th">Quantity</th>
    							<th class="text-center sub-total-th">Subtotal</th>
    							<th class="blank-th"></th>
    						</tr>
    					</thead>
    					<tbody>

                <!-- tr start -->
                <?php if(!empty($_SERVER['HTTP_REFERER'])){
                          $url = $_SERVER['HTTP_REFERER'];
                        }else{
                          $url = 'ombre.php';
                        }

                ?>
                <?php get_cart_products($url); ?>

                <!-- tr end -->


    					</tbody>
    					<tfoot>

    						<tr class="visible-xs">
    							<td class="text-center total_display"><strong>Total 1.99</strong></td>
    						</tr>

    						<tr>
    							<td><a href="<?php echo $url; ?>" class="btn btn-warning continue-shopping-btn"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
    							<td colspan="6" class="hidden-xs"></td>
    							<td class="hidden-xs total_display text-left"><strong>Total $1.99</strong></td>
    							<td><a href="checkout.php" class="btn btn-success btn-block pull-right">Checkout <i class="fa fa-angle-right"></i></a></td>
    						</tr>

    					</tfoot>
    				</table>
          </div>   <!-- Main row end -->
        </div>    <!-- Main column end -->
</div>

<br>
<!-- Cart table end -->

<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>
<!--FOOTER ENDS -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-body bg-danger text-danger">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <strong><p id="cart_error_text"></p></strong>
    </div>
  </div>
</div>
</div>
<script src="bootstrap/dist/js/cart_update_using_ajax.js"></script>
<script src="bootstrap/dist/js/empty_cart.js"></script>
</body>
</html>
