<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>


<!--header ENDS-->



<div class="container">     <!--Container start -->

  <!-- Product image and detail view -->
	<?php

		if(isset($_GET['id'])){
			$product_id = escape_string($_GET['id']);

			//To check if product is locked for more then 10 minutes if yes then redisplay it (defined in functions.php)

			check_locked_products($product_id);

			$xs=$s=$m=$l=$xl=$xxl=null;
			$color[]=null;
			$product_color_id_arr[] = null;
			if(!empty($product_id)){
				$query = query("SELECT * FROM products WHERE product_id = {$product_id}");
				confirm($query);
				if(!rows($query)){
					echo '<h1 class="bg-danger text-danger text-center">Product not found!</h1>';
				}else{
					while($row = fetch_array($query)):
						$saving = $row['product_original_price'] - $row['product_price'];
						$saving_perc = round(($saving/$row['product_original_price'])*100, 2);
						$product_brand_id = $row['brand_id'];

						$product_image_1 = substr($row['product_image_1'],3);
						$product_image_2 = substr($row['product_image_2'],3);
						$product_image_3 = substr($row['product_image_3'],3);
						$product_image_4 = substr($row['product_image_4'],3);
						$product_image_5 = substr($row['product_image_5'],3);

						$brand_query = query("SELECT brand_name FROM brands WHERE brand_id = {$product_brand_id}");
						confirm($brand_query);
						while($brand_row = fetch_array($brand_query)){
							$brand_name = $brand_row['brand_name'];
						}

	?>
	<!--<form method="post" action="<?php echo RESOURCES;?>cart.php?add=<?php echo $product_id;?>">  <!-- Form for size and color selection start -->

		<div class="card">      <!-- card start -->
			<div class="container-fliud">      <!-- Container fluid start -->
				<div class="wrapper row">       <!-- wrapper start -->

					<div class="preview col-md-6">

						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><a href="<?php echo $product_image_1;?>" class="fresco" data-fresco-group="fresco_product_image" data-fresco-caption="Caption1" data-fresco-group-options="overflow: true, thumbnails: 'vertical', onClick: 'close'"><img src="<?php echo $product_image_1;?>"/></a></div>
						  <div class="tab-pane" id="pic-2"><a href="<?php echo $product_image_2;?>" class="fresco" data-fresco-group="fresco_product_image" data-fresco-caption="Caption2"><img src="<?php echo $product_image_2;?>" /></a></div>
						  <div class="tab-pane" id="pic-3"><a href="<?php echo $product_image_3;?>" class="fresco" data-fresco-group="fresco_product_image" data-fresco-caption="Caption3"><img src="<?php echo $product_image_3;?>" /></a></div>
						  <div class="tab-pane" id="pic-4"><a href="<?php echo $product_image_4;?>" class="fresco" data-fresco-group="fresco_product_image" data-fresco-caption="Caption4"><img src="<?php echo $product_image_4;?>" /></a></div>
						  <div class="tab-pane" id="pic-5"><a href="<?php echo $product_image_5;?>" class="fresco" data-fresco-group="fresco_product_image" data-fresco-caption="Caption5"><img src="<?php echo $product_image_5;?>" /></a></div>
						</div>

						<ul class="preview-thumbnail nav nav-tabs">
						  <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="<?php echo $product_image_1;?>" /></a></li>
						  <li><a data-target="#pic-2" data-toggle="tab"><img src="<?php echo $product_image_2;?>" /></a></li>
						  <li><a data-target="#pic-3" data-toggle="tab"><img src="<?php echo $product_image_3;?>" /></a></li>
						  <li><a data-target="#pic-4" data-toggle="tab"><img src="<?php echo $product_image_4;?>" /></a></li>
						  <li><a data-target="#pic-5" data-toggle="tab"><img src="<?php echo $product_image_5;?>" /></a></li>

						</ul>

					</div>

					<div class="details col-md-6">

						<h3 class="product-title"><?php echo $row['product_title']; ?>
							<br><br>
							<small><?php echo $brand_name;?></small>
						</h3>
						<div class="rating">
							<div class="stars">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="label label-success label-lg pull-right" id="stock_label" style="font-size:14px;">In stock</span>
							</div>
							<span class="review-no">41 reviews</span>
						</div>

						<p class="product-description"><?php echo $row['product_short_description']; ?></p>
            <h5 class="original-price">Original price: <span>Rs. <?php echo $row['product_original_price']; ?></span></h5>
            <h4 class="current-price">current price: <span>Rs. <?php echo $row['product_price']; ?></span></h4>
            <h4 class="you-save">you save: <span>Rs. <?php echo $saving.' ('.$saving_perc.' %)'; ?></span></h4>
						<p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>

						<h5 class="colors">colors:
							<!--<span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
							<span class="color green"></span>
							<span class="color blue"></span>-->
							<?php
								$color_query = query("SELECT * from product_color WHERE product_id={$product_id}");
								confirm($color_query);
								$i=0;
								while($color_row = fetch_array($color_query)){
									global $color, $product_color_id_arr, $product_color_qty_arr;
									$product_color_id_arr[$i] = $color_row['product_color_id'];
									$product_color_qty_arr[$i] = $color_row['product_color_qty'];
									$color[$i]=$color_row['product_color_name'];
$color_fields_html = <<<DELIMETER
<input type="radio" name="product_color" hidden id="{$color[$i]}" value="{$color[$i]}">
<label class="color" data-toggle="tooltip" title="{$color[$i]}" for="{$color[$i]}"></label>
DELIMETER;
echo $color_fields_html;


									++$i;
								}
								//$product_color_id = $color_row['product_color_id'];

								$size_query = query("SELECT product_size_name FROM product_size WHERE product_id = {$product_id} AND product_size_qty != 0 ");
								confirm($size_query);
								while($size_row = fetch_array($size_query)){
									global $xs,$s,$m,$l,$xl,$xxl;
									switch($size_row['product_size_name']){
										case "XS": $xs= $size_row['product_size_name'];
										break;
										case "S": $s= $size_row['product_size_name'];
										break;
										case "M": $m= $size_row['product_size_name'];
										break;
										case "L": $l= $size_row['product_size_name'];
										break;
										case "XL": $xl= $size_row['product_size_name'];
										break;
										case "XXL": $xxl= $size_row['product_size_name'];
										break;
									}
								}


							?>

						</h5>

						<h5 class="sizes">sizes:
							<input type="radio" name="product_size" hidden id="xs" value="xs">
							<label class="size" data-toggle="tooltip" title="extra small" for="xs">xs</label>

							<input type="radio" name="product_size" hidden id="s" value="s">
							<label class="size" data-toggle="tooltip" title="small" for="s">s</label>

							<input type="radio" name="product_size" hidden id="m" value="m">
							<label class="size" data-toggle="tooltip" title="medium" for="m">m</label>

							<input type="radio" name="product_size" hidden id="l" value="l">
							<label class="size" data-toggle="tooltip" title="large" for="l">l</label>

							<input type="radio" name="product_size" hidden id="xl" value="xl">
							<label class="size" data-toggle="tooltip" title="extra large" for="xl">xl</label>

							<input type="radio" name="product_size" hidden id="xxl" value="xxl">
							<label class="size" data-toggle="tooltip" title="XXL" for="xxl">xxl</label>

							<!--Hidden Text Field For Product Id -->
							<input type="text" hidden value="<?php echo $product_id;?>" name="product_id">

						</h5>


						<input type="text" hidden name="product_id" value="<?php echo $product_id; ?>" />				<!-- Hidden field for sending product id by clicking add to cart button -->

						<div class="action">
							<button class="add-to-cart btn btn-default submit-btn" type="submit"><span class="fa fa-shopping-cart">&nbsp;&nbsp;add to cart</button>
							<a class="btn btn-default add-to-cart hide go-to-cart" href="cart-items.php">Go to cart ></a>
							<button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
						</div>
					</div>
				</div>    <!-- wrapper end -->
			</div>     <!-- Container fluid end -->
		</div>      <!-- card end -->
	<!--</form>				<!-- Form for size and color selection start -->
    <hr>

    <div class="row"> <!-- Product-decsription row start -->

      <div class="product-description-container col-md-12">     <!-- product description container start -->



        <!-- Tab pills Description Details and Review system -->

        <ul class="nav nav-tabs marg-bot-up">
          <li class="active"><a data-toggle="tab" href="#description">Description</a></li>
          <li><a data-toggle="tab" href="#reviews">Reviews</a></li>
					<li><a data-toggle="tab" href="#details">Details</a></li>
        </ul>

        <div class="tab-content tab-padding">   <!-- tab content start -->

          <div id="description" class="tab-pane fade in active">
            <p>
							<?php echo $row['product_long_description']; ?>
            </p>
          </div>
          <div id="details" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>

          <div id="reviews" class="tab-pane fade">    <!-- review div start-->

            <div class="col-md-6">      <!-- Review form column start -->

             <h3>2 Reviews From </h3>

              <hr>

              <div class="row">  <!--row start -->
                  <div class="col-md-12">
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star-empty"></span>
                      Anonymous
                      <span class="pull-right">10 days ago</span>
                      <p>This product was great in terms of quality. I would definitely buy another!</p>
                  </div>
              </div>    <!-- row end -->

              <hr>

              <div class="row">   <!-- row start -->
                  <div class="col-md-12">
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star-empty"></span>
                      Anonymous
                      <span class="pull-right">12 days ago</span>
                      <p>I've alredy ordered another one!</p>
                  </div>
              </div>    <!--row end -->

              <hr>

              <div class="row">   <!-- row start -->
                  <div class="col-md-12">
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star"></span>
                      <span class="glyphicon glyphicon-star-empty"></span>
                      Anonymous
                      <span class="pull-right">15 days ago</span>
                      <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
                  </div>
              </div>      <!--row end -->

            </div>      <!-- Review form column end -->

            <div class="col-md-6">      <!-- Add review column start -->

              <h3>Add A review</h3>

             <form action="" class="form-inline">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="test" class="form-control">
                </div>

                <div>
                    <h3>Your Rating</h3>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                </div>

                <br>

                <div class="form-group">
                     <textarea name="" id="" cols="60" rows="10" class="form-control"></textarea>
                </div>

                <br>
                <br>

                <div class="form-group review-button">
                        <input type="submit" class="btn btn-primary" value="SUBMIT">
                </div>

              </form>

            </div>    <!-- Add review column end -->

          </div>    <!-- review div end-->

        </div>    <!-- tab content end -->

      </div>    <!-- product description container end -->

  </div>        <!-- Product-decsription row end -->

</div>     <!--Container end -->

<?php
				endwhile;
				}
			}else{
			echo "<h1 class='bg-danger text-danger'>Product ID is missing!</h1>";
			}
		}else{
		echo "<h1 class='bg-danger text-danger'>Product ID is missing!</h1>";
		}

?>

  <!-- FOOTER -->
	<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

	<!--Footer ends-->

	<!--Modal Form Error Reporting (FORM VALIDATION) -->

	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body bg-danger text-danger">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
        <strong><p id="form_error_text"></p></strong>
      </div>
    </div>
  </div>
</div>
<!-- Checking Wether item is already in cart and changing the Add to cart to Go to cart -->
<?php
$item_present = false;
foreach ($_SESSION as $key => $value) {
	if($key=="product_".$product_id){
		$item_present = true;
	}
}
?>

  </body>


<script>
/*//Changing Add to cart to Go to cart button if item present
var item_present = "<?php echo $item_present;?>";
if(item_present !=""){
	$('.submit-btn').hide();
	$('.go-to-cart').removeClass("hide");
}*/
</script>

<script>
//color script variables (used in product_color.js)
var color_name = [];
var color_qty = [];
color_name = <?php echo json_encode($color);?>;
color_qty = <?php echo json_encode($product_color_qty_arr);?>;
</script>

<script src="bootstrap/dist/js/product_color.js"></script>

<script>

//size script variables  (used in product_color.js)

var xs = '<?php echo $xs;?>';
var s = '<?php echo $s;?>';
var m = '<?php echo $m;?>';
var l = '<?php echo $l;?>';
var xl = '<?php echo $xl;?>';
var xxl = '<?php echo $xxl;?>';
var product_id = '<?php echo $product_id; ?>';
var color_ids_arr = <?php echo json_encode($product_color_id_arr);?>;
var color_ids_arr_length = color_ids_arr.length;
var color_name = "";
var color_sizes_arr = [];

</script>
<script src="bootstrap/dist/js/product_size.js"></script>
<script src="bootstrap/dist/js/out_of_stock.js"></script>
<script src="bootstrap/dist/js/product_form_validation_submission(AJAX).js"></script>

</html>
