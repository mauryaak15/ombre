<?php

include_once("../../config.php");

//Ajax call function from add_existing_product.js(To find existing products)

if(isset($_POST['method'])&&isset($_POST['query'])&&!empty($_POST['method'])&&function_exists($_POST['method'])){
  $functionName = $_POST['method'];
  $data = $_POST['query'];
  switch($functionName){
    case 'existProductFunction': echo existProductFunction($data);
        break;
    case 'existSizeFunction': echo existSizeFunction($data);
        break;
    case 'existColorFunction': echo existColorFunction($data);
        break;
    case 'deleteProductFunction': echo deleteProductFunction($data);
        break;
    default:
        die('Access denied for this function!');
  }
}

function existProductFunction($data){
  if($data==""){
    echo json_encode(array());  //If query is empty then send empty array
  }else{
    $query = query("SELECT product_title,product_id FROM products WHERE product_title LIKE '%{$data}%'");
    confirm($query);
    $i=0;
    if(rows($query)==0){  //If no result found then send empty array
      echo json_encode(array("empty"));
    }else{
      while($row = fetch_array($query)){
        $result[$i] = new stdClass();
        $product_title = $row['product_title'];
        $product_id = $row['product_id'];
        $result[$i]->id = $product_id;
        $result[$i]->title = $product_title;
        ++$i;
      }
      echo json_encode($result);
    } //else end
  }

}

//Particular product size fetch and display in select options
function existSizeFunction($data){
  if($data==""){
    echo json_encode(array());  //If query is empty then send empty array
  }else{
    $query = query("SELECT DISTINCT product_size_name FROM product_size WHERE product_id = {$data}");
    confirm($query);
    $i=0;
    if(rows($query)==0){  //If no result found then send empty array
      echo json_encode(array("empty"));
    }else{
      while($row = fetch_array($query)){
        $result[$i] = new stdClass();
        $size_name = $row['product_size_name'];
        //$size_id = $row['product_size_id'];
        //$result[$i]->id = $size_id;
        $result[$i]->size_name = $size_name;
        ++$i;
      }
      echo json_encode($result);
    } //else end
  }

}

//Particular product color fetch and display in select options
function existColorFunction($data){
  if($data==""){
    echo json_encode(array());  //If query is empty then send empty array
  }else{
    $query = query("SELECT DISTINCT product_color_name FROM product_color WHERE product_id = {$data}");
    confirm($query);
    $i=0;
    if(rows($query)==0){  //If no result found then send empty array
      echo json_encode(array("empty"));
    }else{
      while($row = fetch_array($query)){
        $result[$i] = new stdClass();
        $color_name = $row['product_color_name'];
        //$size_id = $row['product_size_id'];
        //$result[$i]->id = $size_id;
        $result[$i]->color_name = $color_name;
        ++$i;
      }
      echo json_encode($result);
    } //else end
  }

}

/****************************Ajax call function from edit_delete_product.js*******************************/

//Function to delete product
function deleteProductFunction($data){

  /*Before deleting the product check if that product is already there in user's cart
   If yes then remove that product from the user's cart*/
  $check_product_cart_query = query("DELETE FROM cart_items WHERE product_id = {$data[0]} AND product_color_id = {$data[1]} AND product_size_id = {$data[2]}");
  confirm($check_product_cart_query);

  $delete_size_query = query("DELETE from product_size WHERE product_size_id = {$data[2]}");
  confirm($delete_size_query);
  //Check if the deleted product's color has more sizes in product size table
  $check_color_size = query("SELECT * FROM product_size WHERE product_color_id = {$data[1]}");
  confirm($check_color_size);

  if(rows($check_color_size) > '0'){
    //If more sizes are present in that color then only decrement the qty of that color in product color Table
    $dec_color_qty_query = query("UPDATE product_color SET product_color_qty = product_color_qty - {$data[3]} WHERE product_color_id = {$data[1]}");
    confirm($dec_color_qty_query);
  }else{
    //If no sizes are present in that color then delete the record from the product color table
    $delete_color_query = query("DELETE from product_color WHERE product_color_id = {$data[1]}");
    confirm($delete_color_query);
  }

  //Check if the deleted product has more colors in product color table
  $check_product_color = query("SELECT * FROM product_color WHERE product_id = {$data[0]}");
  confirm($check_product_color);

  if(rows($check_product_color) > '0'){
    //If more product available in color table then do not delete the product in product table only decrement the Quantity
    $dec_product_qty_query = query("UPDATE products SET product_qty = product_qty - {$data[3]} WHERE product_id = {$data[0]}");
    confirm($dec_product_qty_query);
  }else{
    $delete_product_query = query("DELETE from products WHERE product_id = {$data[0]}");
    confirm($delete_product_query);
  }
  $result[0] = 1;
  echo json_encode($result);
}

?>
