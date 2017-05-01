//To hide the order table if there are no orders for the user

console.log(order_count);
if(order_count == -10){
  $(".error_text").html("Please Log In!");
  $('.order_table_row').remove();
  $('.no_orders_div').removeClass("hidden");
}
else if(order_count <= 0){
  $('.order_table_row').remove();
  $('.no_orders_div').removeClass("hidden");
}
