/*
(FOR CART_ITEMS.PHP)
All the increment and decrement of quantity of product.
Total and subtotal display
Remove button functioning
*/

var new_qty;
var old_qty;
var ids_string;
var qty_input = $("input[type='number']");
var ids_arr = [];
var total = 0;
var sub_total=0;
var price;
var sub_total_td;
var price_td;
var changed_subtotal;
var old_qty;
var current_input;
var span;
var stock;

$("td[data-th='Subtotal']").each(function(){
  sub_total = parseInt($(this).attr("data-sub-total"), 10);
  total += sub_total;
});
$(".total_display strong").html("Total Rs. "+total);

//Prevents keyboard input in qty field
/*qty_input.keypress(function (evt) {
    evt.preventDefault();
});*/

qty_input.on({
  change:function(){
    new_qty = $(this).val();
    old_qty = $(this).attr("value");
    current_input = $(this);

    //to check if number is float or not
    if(typeof parseFloat(new_qty) === 'number'){
      if(new_qty > 0){
        if(new_qty%1 !=0){
          new_qty = parseInt(new_qty);
          $(this).val(new_qty);
        }
      }
    }

    if(new_qty==""){
      $(this).val(0);
      $(this).attr("value",0);
    }
    ids_string = $(this).attr("data-product-ids");
    ids_arr = ids_string.split("_");
    sub_total_td = $(this).parent().parent().children(".sub_total");
    price_td = $(this).parent().parent().children(".product_price");
    span = $(this).parent().next().next().children(".cart_stock_label");

    $.ajax({
      type:"POST",
      url:"resources/cart.php",
      data:"product_id="+ids_arr[0]+"&color_id="+ids_arr[1]+"&size_id="+ids_arr[2]+"&qty="+new_qty,
      cache: false,
      success: function(result){
        if(result.trim() == "Product is out of stock!"){
            $("#cart_error_text").html(result);
            $("#myModal").modal('show');
            sub_total_td.html("Rs. 0");
            sub_total_td.attr("data-sub-total","0");
            span.removeClass("label-success").addClass("label-warning").html("Out of stock");
            current_input.attr("disabled","disabled").val(old_qty);
            new_qty = 0;
          }else if(result.trim()=="Please give a valid input!"){
            $("#cart_error_text").html(result);
            $("#myModal").modal('show');
            current_input.attr("value",old_qty).val(old_qty);
            new_qty = old_qty;
          }else if(result.trim() == "Product not found!"){
            $("#cart_error_text").html(result);
            $("#myModal").modal('show');
            current_input.attr("value",old_qty).val(old_qty);
            new_qty = old_qty;
          }else if(result.trim() == "This item is not in cart!"){
            $("#cart_error_text").html(result);
            $("#myModal").modal('show');
            current_input.attr("value",old_qty).val(old_qty);
            new_qty = old_qty;

          }else if(result.trim() == "ID is missing!"){
            $("#cart_error_text").html(result);
            $("#myModal").modal('show');
            current_input.attr("value",old_qty).val(old_qty);
            new_qty = old_qty;
          }else if(result.trim() != "1"){
            $("#cart_error_text").html(result);
            $("#myModal").modal('show');
            current_input.attr("value",old_qty).val(old_qty);
            new_qty = old_qty;
          }
            total = 0;
            price = parseInt(price_td.attr("data-price"), 10);
            changed_subtotal = new_qty*price;
            current_input.attr("value",new_qty);
            sub_total_td.html("Rs. "+changed_subtotal);
            $("td[data-th='Subtotal']").not(sub_total_td).each(function(){
              sub_total = parseInt($(this).attr("data-sub-total"), 10);
              total += sub_total;
            });
            total = total + changed_subtotal;
            $(".total_display strong").html("Total Rs. "+total);
      }
    });
  }
});

$(".remove_product").on("click",function(){
  ids_string = $(this).attr("data-product-ids");
  ids_arr = ids_string.split("_");
  var last_tr = $("#cart tbody tr:only-child");
  var tr = $(this).parent().parent();
  sub_total_td = tr.children(".sub_total");
  $.ajax({
    type: "POST",
    url: "resources/cart.php",
    data: "removePId="+ids_arr[0]+"&removeColorId="+ids_arr[1]+"&removeSizeId="+ids_arr[2],
    cache: false,
    success: function(result){
      total=0;
      if(result.trim() == "Item is not in cart!"){
        $("#cart_error_text").html(result);
        $("#myModal").modal('show');
      }
      last_tr.each(function(){
        $(".cart-count").empty();
        $("#cart").hide("slow",function(){ $("#cart").remove(); });
        $(".cart_empty_message").html("Your cart is empty!").removeClass("hide");
        $(".cont_shopping_btn").removeClass("hide");
      });
        if(result.trim() > "0"){
          $(".cart-count").html(result.trim());
        }
        tr.hide('slow', function(){ tr.remove(); });
        $("td[data-th='Subtotal']").not(sub_total_td).each(function(){
          sub_total = parseInt($(this).attr("data-sub-total"), 10);
          total += sub_total;
        });
        $(".total_display strong").html("Total Rs. "+total);
      }
    });
  });

//Checking item in cart is in stock right now or not
$("tr").each(function(){
  if($("tr").is("[data-stock]")){
    var tr = $(this);
    if(tr.attr("data-stock")=='1'){
      tr.find(".cart_stock_label").removeClass("label-success").addClass("label-warning").html("Out of stock");
      tr.find("input[type='number']").attr("disabled","disabled");
    }
  }

});
