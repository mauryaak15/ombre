<?php require_once("config.php"); ?>

<?php

/****************************************Helper functions for cart processing******************************************************/


/***************Fetching product info queries*****************/

//Get Total quantity of selected product

function get_product_total_qty($product_id){
  $query_product_total_qty = query("SELECT product_qty FROM products WHERE product_id={$product_id}");
  confirm($query_product_total_qty);
  while($row = fetch_array($query_product_total_qty)){
    $product_total_qty = $row['product_qty'];
  }
  return $product_total_qty;
}

//Get product color id and product color quantity of selected product color

function get_product_color_info($product_id,$product_color){
  $query_product_color_info =  query("SELECT * FROM product_color WHERE product_id={$product_id} AND product_color_name='{$product_color}'");
  confirm($query_product_color_info);
  if(rows($query_product_color_info)!=0){
    while($row = fetch_array($query_product_color_info)){
      $product_color_info['product_color_qty'] = $row['product_color_qty'];
      $product_color_info['product_color_id'] = $row['product_color_id'];

    }
  }else{
    $product_color_info = 0;
  }

  return $product_color_info;
}

//Get product size id and quantity of selected product size

function get_product_size_qty($product_id,$product_color_id,$product_size_name){
  $query_product_size_info =  query("SELECT * FROM product_size WHERE product_id={$product_id} AND product_color_id='{$product_color_id}' AND product_size_name='{$product_size_name}'");
  confirm($query_product_size_info);
  if(rows($query_product_size_info)!= 0){
    while($row = fetch_array($query_product_size_info)){
      $product_size_info['product_size_id'] = $row['product_size_id'];
      $product_size_info['product_size_qty'] = $row['product_size_qty'];
    }
  }else{
    $product_size_info = 0;
  }

  return $product_size_info;
}

?>
