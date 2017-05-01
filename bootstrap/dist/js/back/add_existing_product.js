/*Variable declared in add_product.php*/
$(document).ready(function(){

  //To hide and show the select product title and radio buttons

  $("select[name='new_or_exist_product']").change(function(){

    var new_exist = $(this).val();
    if(new_exist == 'exist'){
      $(".search_product_div").show('ease-in-out');
      if(opt.length){ //TO reshow if valid product is selected directly after selecting exist option
        $(".color_size_div").show("ease-in-out");
      }
    }else{
      $(".search_product_div").hide('ease-in-out');//hide the product title field
      //$("input[name='product_id']").val("");//Clear the product title field
      $("#product_list").html(""); //Clear the datalist of searched item
      $(".color_size_div").hide("ease-in-out"); //To hide radio if option new is seleted
      $("input[name='color_or_size']").prop("checked",false);//Clear all radio buttons
      $(".existing_size_div").hide("ease-in-out");//hide the size select input
      $(".existing_size_div select").html("");//clear the size select options
      $(".existing_color_div").hide("ease-in-out");//hide the color of color select input
      $(".existing_color_div select").html("");//clear the color select options
    }

  }); //Change event end

  //To populate the datalist option from matching search text in products table

  $("#product").keyup(function(){

      var search_text = $(this).val();
      $.ajax({
        dataType: "json",
        url: "../resources/templates/back/ajax_functions_calls.php",
        type:"POST",
        cache: false,
        data: {method:'existProductFunction',query:search_text},
        success: function(result){
          console.log(JSON.stringify(result));
          if(JSON.stringify(result)=='["empty"]'){ //If query is not empty and result is empty
            $(".no_result_text").show("ease-in-out").html("Sorry no product found!");
            $("#product_list").html("");
          }else if(JSON.stringify(result)=='[]'){ //If query is empty and result is empty
            $(".no_result_text").hide("ease-in-out");
            $("#product_list").html("");
          }else{  //If result is not empty
            var i = 0;
            $(".no_result_text").hide("ease-in-out");
            $("input[name='color_or_size']").prop("checked",false);//Clear all radio buttons
            $(".existing_size_div").hide("ease-in-out");  //Hide size select box
            $(".existing_size_div select").html("");  //clear size select options
            $(".existing_color_div").hide("ease-in-out");  //Hide color select box
            $(".existing_color_div select").html("");  //clear color select options
            $.each(result,function(index,obj){  //Loop through json object array eg.[{id:'1',title:'abcd'},{id:'2',title:'zxy'}]
              $.each(obj,function(key,value){ //Loop through json object eg. {id:'1',title:'abcd'}
                if(key!="id"){  //As loop will run for every property of obj therefore to create options for the title property only
                  var option = '<option value="'+value+'">'+obj.id+'</option>';
                  if(i>0){  //If query result has more than one product then append the options
                    $("#product_list").append(option);
                  }else{  //If loop is running for the first time then clear the previous written options to avoid redundancy
                    $("#product_list").html(option);
                  }
                }else{  //Skiping id proerty loop iteration
                  return true;  //Works like a continue in loops
                }
                ++i;
              }); //2nd each loop end

            }); //!st each loop end
          } //result is not empty else end

        },  //Success method end
        error: function(XMLHttpRequest, textStatus, errorThrown){
          console.log("Status: " + textStatus);
          console.log("Error: " + errorThrown);
        }
      }); //Ajax function end

  }); //keyup event end

  //To display radio button if product is existing and valid product option is selectd

  var opt = ''; //Global var because using above in new or exist check
  $("input[name='product_id']").on('input',function(){
    opt = $('option[value="'+$(this).val()+'"]'); //Option which have same value as of input value
    var id = opt.html();
    if(opt.length==0){  //IF option is not seleted
      $(".color_size_div").hide("ease-in-out");
      $("input[name='product_id_hidden'").removeAttr("value");  //Removing the id of product from the hidden field when product title is not selected
      $("input[name='color_or_size']").prop("checked",false);//Clear all radio buttons
      $(".existing_size_div").hide("ease-in-out");  //Hide size select box
      $(".existing_size_div select").html("");  //clear size select options
      $(".existing_color_div").hide("ease-in-out");  //Hide color select box
      $(".existing_color_div select").html("");  //clear color select options
    }else{
      if(opt.length){ //If Option which have same value as of input value is present(option is selected)
        $(".color_size_div").show("ease-in-out");
        $("input[name='product_id_hidden'").attr("value",id); //Passing the id of product to the hidden field when product title is selected
      }else{
        $(".color_size_div").hide("ease-in-out");
      }
    }
  }); //input event end

  $("input[name='color_or_size']").change(function(){
    if($("input[name='color_or_size']:checked").val()=="size"){

      $(".existing_color_div").hide("ease-in-out");//hide the color of color select input
      $(".existing_color_div select").html("");//clear the color select options

      //When Existing Product is selected and then Existing size option is selected

      var id = $("input[name='product_id_hidden'").attr("value");
      $.ajax({
        dataType: "json",
        url: "../resources/templates/back/ajax_functions_calls.php",
        type:"POST",
        cache: false,
        data: {method:'existSizeFunction',query:id},
        success: function(result){
          console.log(JSON.stringify(result));
          if(JSON.stringify(result)=='["empty"]'){ //If query is not empty and result is empty
            $(".existing_size_div").show("ease-in-out");
            $("select[name='exist_product_size']").html('<option value="" selected disabled>No size found</option>');
          }else if(JSON.stringify(result)=='[]'){ //If query is empty and result is empty

          }else{  //If result is not empty
            var i = 0;
            $.each(result,function(index,obj){  //Loop through json object array eg.[{id:'1',title:'abcd'},{id:'2',title:'zxy'}]
              $.each(obj,function(key,value){ //Loop through json object eg. {id:'1',title:'abcd'}
                //var option = '<option value="'+obj.id+'">'+value+'</option>';
                var option = '<option value="'+value+'">'+value+'</option>';
                if(key!="id"){  //As loop will run for every property of obj therefore to create options for the title property only
                  if(i>0){
                    $(".existing_size_div").show("ease-in-out");
                    $("select[name='exist_product_size']").append(option);
                  }else{  //If first time option is being created then delete the previous option if exist
                    $(".existing_size_div").show("ease-in-out");
                    $("select[name='exist_product_size']").html(option);
                  }
                }else{
                  return true;
                }
                ++i;
              }); //2nd each loop end

            }); //!st each loop end
          } //result is not empty else end

        },  //Success method end
        error: function(XMLHttpRequest, textStatus, errorThrown){
          console.log("Status: " + textStatus);
          console.log("Error: " + errorThrown);
        }
      }); //Ajax function end


    }else if($("input[name='color_or_size']:checked").val()=="color"){

      $(".existing_size_div").hide("ease-in-out");//hide the size select input
      $(".existing_size_div select").html("");//clear the size select options

      //When Existing Product is selected and then Existing size option is selected

      var id = $("input[name='product_id_hidden'").attr("value");
      $.ajax({
        dataType: "json",
        url: "../resources/templates/back/ajax_functions_calls.php",
        type:"POST",
        cache: false,
        data: {method:'existColorFunction',query:id},
        success: function(result){
          console.log(JSON.stringify(result));
          if(JSON.stringify(result)=='["empty"]'){ //If query is not empty and result is empty
            $(".existing_color_div").show("ease-in-out");
            $("select[name='exist_product_color']").html('<option value="" selected disabled>No color found</option>');
          }else if(JSON.stringify(result)=='[]'){ //If query is empty and result is empty

          }else{  //If result is not empty
            var i = 0;
            $.each(result,function(index,obj){  //Loop through json object array eg.[{id:'1',title:'abcd'},{id:'2',title:'zxy'}]
              $.each(obj,function(key,value){ //Loop through json object eg. {id:'1',title:'abcd'}
                //var option = '<option value="'+obj.id+'">'+value+'</option>';
                var option = '<option value="'+value+'">'+value+'</option>';
                if(key!="id"){  //As loop will run for every property of obj therefore to create options for the title property only
                  if(i>0){
                    $(".existing_color_div").show("ease-in-out");
                    $("select[name='exist_product_color']").append(option);
                  }else{  //If first time option is being created then delete the previous option if exist
                    $(".existing_color_div").show("ease-in-out");
                    $("select[name='exist_product_color']").html(option);
                  }
                }else{
                  return true;
                }
                ++i;
              }); //2nd each loop end

            }); //!st each loop end
          } //result is not empty else end

        },  //Success method end
        error: function(XMLHttpRequest, textStatus, errorThrown){
          console.log("Status: " + textStatus);
          console.log("Error: " + errorThrown);
        }
      }); //Ajax function end


    }else if($("input[name='color_or_size']:checked").val()=="none"){
      $(".existing_size_div").hide("ease-in-out");//hide the size select input
      $(".existing_size_div select").html("");//clear the size select options
      $(".existing_color_div").hide("ease-in-out");//hide the color of color select input
      $(".existing_color_div select").html("");//clear the color select options
    }
  });

}); //document.ready end
