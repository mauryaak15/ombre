<?php include_once("../resources/config.php");?>
<?php require_once(TEMPLATE_BACK.DS."header.php"); ?>

<?php
if(!isset($_SESSION['admin_id'])){
  set_message("Invalid Request");
  redirect('../ombre.php');
  die();
}
?>

<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->

                <!-- row start-->

                <?php

                if($_SERVER['REQUEST_URI'] == '/ombre/public/admin/' || $_SERVER['REQUEST_URI'] == '/ombre/public/admin/index.php'){
                  include(TEMPLATE_BACK.DS."admin_content.php");
                }
                if(isset($_GET['orders'])){
                  include(TEMPLATE_BACK.DS."orders.php");
                }
                if(isset($_GET['add_new_exist_product'])){
                  include(TEMPLATE_BACK.DS."add_existing_product_check.php");
                }
                if(isset($_GET['add_product'])){
                  include(TEMPLATE_BACK.DS."add_product.php");
                }
                if(isset($_GET['all_products'])){
                  include(TEMPLATE_BACK.DS."all_products.php");
                }
                if(isset($_GET['categories'])){
                  include(TEMPLATE_BACK.DS."categories.php");
                }
                if(isset($_GET['edit_product'])){
                  include(TEMPLATE_BACK.DS."edit_product.php");
                }
                if(isset($_GET['users'])){
                  include(TEMPLATE_BACK.DS."users.php");
                }
                if(isset($_GET['add_user'])){
                  include(TEMPLATE_BACK.DS."add_user.php");
                }
                if(isset($_GET['edit_user'])){
                  include(TEMPLATE_BACK.DS."edit_user.php");
                }
                if(isset($_GET['reports'])){
                  include(TEMPLATE_BACK.DS."reports.php");
                }


                ?>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->



    <?php require_once(TEMPLATE_BACK.DS."footer.php"); ?>
    <Script type="text/javascript" src="../bootstrap/dist/js/back/preview_image_before_upload.js"></script>
    <Script type="text/javascript" src="../bootstrap/dist/js/back/add_existing_product.js"></script>
    <Script type="text/javascript" src="../bootstrap/dist/js/back/add_product.js"></script>
    <script type="text/javascript" src="../bootstrap/dist/js/back/edit_delete_product.js"></script>
  </body>

  </html>
