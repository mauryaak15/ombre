<?php require_once("resources/config.php");

if(isset($_POST['product_color_name'])&&isset($_POST['product_id'])){
  $i = 0;
  $product_size_arr[] = null;
  $product_color_name = escape_string($_POST['product_color_name']);
  $product_id = escape_string($_POST['product_id']);
  if(!empty($product_color_name)&&!empty($product_id)){
    $query_for_color_id = query("SELECT product_color_id FROM product_color WHERE product_color_name='{$product_color_name}' AND product_id={$product_id}");
    confirm($query_for_color_id);
    while($id_row = fetch_array($query_for_color_id)){
      $product_color_id = $id_row['product_color_id'];
    }
    $query_for_sizes = query("SELECT product_size_name FROM product_size WHERE product_color_id={$product_color_id} AND product_id={$product_id} AND product_size_qty > 0");
    confirm($query_for_sizes);
    while($size_row = fetch_array($query_for_sizes)){
      global $product_size_arr;
      $product_size_arr[$i] = $size_row['product_size_name'];
      ++$i;
    }
    echo json_encode($product_size_arr);

  }
}





?>
