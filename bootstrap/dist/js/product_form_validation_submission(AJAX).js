
/*Add to Cart button functioning
(Used in product-info.php)
*/

//To change back got to cart to add to cart
$("input[name='product_color']").change(function(){
  $('.submit-btn').show("slow","swing");
  $('.go-to-cart').addClass("hide");
});


//Add to cart functioning starts here

$('.submit-btn').click(function(){
  if($("input[name='product_color']").is(":checked")==false){
    $("#form_error_text").html("Please select color!")
    $("#myModal").modal('show');
  }else if($("input[name='product_size']").is(":checked")==false){
    $("#form_error_text").html("Please select size!")
    $("#myModal").modal('show');
  }else{

        var product_color = $('input[name="product_color"]:checked').val();
        var product_size = $('input[name="product_size"]:checked').val();
        var product_id = $('input[name="product_id"]').val();
        var dataString = 'product_color='+product_color+'&product_size='+product_size+'&add='+product_id;
        $.ajax({
          type: "POST",
          url: "resources/cart.php",
          data: dataString,
          cache: false,
          success: function(result){
            if(result.trim() == "0"){
              $("#form_error_text").html("Something went wrong!")
              $("#myModal").modal('show');
            }else if(result.trim() == "-1"){
              $("#form_error_text").html("Not more available, please select different color or size!")
              $("#myModal").modal('show');
            }else{
              $('.cart-count').html(result);
            }
            if((result.trim() != "-1") && (result.trim() != "0")){
              $('input:checked').prop("checked",false);
              $('.submit-btn').hide("slow","swing");
              $('.go-to-cart').removeClass("hide");
            }
          }
          });
  }
  return false;
});
