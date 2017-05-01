/* Checking wether product is in stock or not and disabling Add to cart button (included in product_info.php) */

var i=0;
var j=0;
$("input[name='product_color']").each(function(){
  if($(this).is(":disabled")){
    ++i;
  }
});
$("input[name='product_size']").each(function(){
  if($(this).is(":disabled")){
    ++j;
  }
});
if(i==color_length && j==6){
  $("#stock_label").removeClass("label-success").addClass("label-danger").html("Out of stock");
  $(".submit-btn").attr("disabled","disabled").attr("title","Out of stock").html("Out of stock");
}
