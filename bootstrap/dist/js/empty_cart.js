//Remove cart table structure when cart is empty (included in cart-items.php)

if(cart_count==0){
  $("#cart").hide("fast");
  $(".cart_empty_message").html("Your cart is empty!").removeClass("hide");
  $(".cont_shopping_btn").removeClass("hide");
}
