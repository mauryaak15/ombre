<?php require_once("resources/config.php"); ?>

<?php require_once(TEMPLATE_FRONT.DS."header.php"); ?>


<!--header ENDS-->

<div class="container">     <!--Container start -->

  <?php $order_count = return_order_count(); ?>
  <?php if(!isset($_SESSION['user_id'])){
    $order_count = -10;
  }?>
  <div class="jumbotron no_orders_div hidden">
    <h1 class="animated slideInLeft error_text">No orders found!</h1>
  </div>

  <div class="row order_table_row">   <!--row start-->
    <div class="col-md-12 table-responsive">
        <h1 class="order-title text-info">Your orders</h1>
        <table class="order-table table">
            <tr>
              <th>Order id</th>
              <th class="text-center">Order quantity</th>
              <th>Order amount</th>
              <th>Order status</th>
              <th>Mode of payment</th>
              <th>Placed on</th>
              <th>Delivery date</th>
              <th>Shipping address</th>
              <th></th>

            </tr>
            <?php display_orders();?>
         </table>
      </div>
  </div>    <!---row end-->

</div>      <!--container end-->


<script>
var order_count = "<?php echo $order_count;?>";
//order_count = parseInt(order_count);

</script>
<script src="bootstrap/dist/js/orders.js"></script>
<!-- FOOTER -->

<?php require_once(TEMPLATE_FRONT.DS."footer.php"); ?>

<!--Footer ends-->
