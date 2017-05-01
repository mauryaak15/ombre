/*To edit or delete product in all_products.php */
$(document).ready(function(){

  //If no product found then show no product found message
  if(products_count == '0'){
    console.log(products_count);
    $(".all_products_table").hide("fast",function(){ $(".all_products_table").remove(); });
    $(".no_product_msg").show("ease-in-out");
  }

  $(".delete_product_btn").on("click",function(){
    var product_ids = $(this).attr("data-product-id");
    var product_ids_array = product_ids.split("_"); //index info --> [0]=product_id, [1]=color_id, [2]=size_id, [3]=product_qty
    var current_product_tr = $(this).parent().parent();
    var last_tr = $(".all_products_table .tbody_tr:last-child");
    $.ajax({
      dataType: "json",
      url: "../resources/templates/back/ajax_functions_calls.php",
      type: "POST",
      cache: false,
      data: {method:'deleteProductFunction',query:product_ids_array},
      success: function(result){
        if(result[0]){
          $(".response_msg h2").html("Product deleted successfully!");
          $(".response_msg").removeClass("alert-success").addClass("alert-danger").show("ease-in-out");
          current_product_tr.hide('slow', function(){current_product_tr.remove();});
          last_tr.each(function(){
            console.log("last tr");
            $(".all_products_table").hide("slow",function(){ $(".all_products_table").remove(); });
            $(".no_product_msg").show("ease-in-out");
          });
        }else{
          $(".response_msg h2").html("Something went wrong!");
          $(".response_msg").removeClass("alert-success").addClass("alert-danger").show("ease-in-out");
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
      }
    }); //Ajax call ends
  }); //On click event ends

}); //document ready ends
