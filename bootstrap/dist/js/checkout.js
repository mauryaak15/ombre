
//Regular Expressions

var addregexp = /^[a-zA-Z_ ]*$/;    //Regexp for state and city
var zipregexp = /^[0-9\-_]{6}$/;  //Regexp for zipcode
var numberregexp = /^[^0-6][0-9\-_]{0,10}$/;  //Regexp for mobile number

$(document).ready(function(){

  //if no address saved then display no address found text
  if(address_found == '1'){
    $(".address_not_found_div").removeClass("hide");
  }

  //Change border ,font-size,place green tick mark when address is selected by user
  $('.address_checkox').change(function(){
    $('.address_checkox').next().removeClass("selected_address").css({"border":"","border-collapse": ""});
    $('.address_checkox').next().find(".address_holder_name").css("font-size","");
    if($(this).is(":checked")){
      $(this).next().addClass("selected_address").css({"border":"1px solid #009900","border-collapse": "separate"});
      $(this).next().find(".address_holder_name").css("font-size","30px");
    }
  });

  //Delete address in checkout using ajax
  $('.delete-btn').click(function(){
    var address_id_string = $(this).attr("data-address-id").split("_");
    var address_id = parseInt(address_id_string[2]);
    var current_address_label  = $(this).parent().parent().parent().parent().parent();
    $.ajax({
      type: "POST",
      url: "ajax_user_address_checkout.php",
      data: "delete_address_id="+address_id,
      cache: false,
      success: function(result){
        if(result.trim() == "Something went wrong!"){
          console.log("Client manipulated address id!");
          $('#error_text').text(result.trim());
          $('#errorModal').modal('show');
        }else if(result.trim() == '1'){ //else if start
          current_address_label.fadeOut(300,function(){
            $(this).remove();
            //To check if more address are there or not if not then show not found text
            if(! $('.items').find('.address_label').length){
              $(".address_not_found_div").removeClass("hide");
            }

          });
        }// else if end
      } //success method end
    }); //ajax method end

  });// click event end

  //Edit address in checkout using ajax
  $('.edit-btn').click(function(){
    var address_id_string = $(this).attr("data-address-id").split("_");
    var address_id = parseInt(address_id_string[2]);
    $.ajax({
      type: "POST",
      url: "ajax_user_address_checkout.php",
      data: "edit_address_id="+address_id,
      cache: false,
      success: function(result){
        if(result.trim() == "Something went wrong!"){
          console.log("Client manipulated address id!");
          $('#error_text').text(result.trim());
          $('#errorModal').modal('show');
        }else{ //else if start

          address_info_object = JSON.parse(result);
          $("#editAddressForm #address").val(address_info_object.address);
          $("#editAddressForm #city").val(address_info_object.city);
          $("#editAddressForm #state").val(address_info_object.state);
          $("#editAddressForm #zip").val(address_info_object.zipcode);
          $("#editAddressForm #number").val(address_info_object.phone);
          $("#editAddressForm #general_address_id").val(address_id);
          $("#editAddressForm #general_address_id").prop("name","update_address_id");
          $('#editAddressModal .modal-title ').text("UPDATE ADDRESS");

          //To remove any border before showing modal because we are using same modal for both update and delete
          $('#editAddressModal input').each(function(){
            $(this).removeClass("input_field_error_border input_field_success_border");
            $(this).not('#general_address_id').next().remove();  //To remove any error message if present before showing
          });
          //For textarea field
          $("#editAddressModal #address").removeClass("input_field_error_border input_field_success_border");
          $("#editAddressModal #address").next().remove();
          //To change the submit button text and icon
          $('#editAddressModal button[type="submit"]').text("");  //To remove previous text between button because we are appending
          $('#editAddressModal button[type="submit"]').append('<span class="fa"></span> Update').prop("title","Update Address");
          $('#editAddressModal button[type="submit"] span').removeClass("fa-plus").addClass("fa-pencil");
          $("#editAddressModal").modal('show');
        }// else if end
      } //success method end
    }); //ajax method end

  });// click event end

  //Add new address in checkout
  $('.add_address_btn').click(function(){
    $("#editAddressForm #address").val("");
    $("#editAddressForm #city").val("");
    $("#editAddressForm #state").val("");
    $("#editAddressForm #zip").val("");
    $("#editAddressForm #number").val("");
    $("#editAddressForm #general_address_id").prop("name","add_address_id");
    $("#editAddressForm #general_address_id").val("");
    $('#editAddressModal .modal-title').text("ADD NEW ADDRESS");

    //To remove any border before showing modal because we are using same modal for both update and delete
    $('#editAddressModal input').each(function(){
      $(this).removeClass("input_field_error_border input_field_success_border");
      $(this).not('#general_address_id').next().remove();  //To remove any error message if present before showing
    });

    //For textarea field
    $("#editAddressModal #address").removeClass("input_field_error_border input_field_success_border");
    $("#editAddressModal #address").next().remove();
    //To change the submit button text and icon
    $('#editAddressModal button[type="submit"]').text("");    //To remove previous text between button because we are appending
    $('#editAddressModal button[type="submit"]').append('<span class="fa"></span> ADD').prop("title","Add New Address");
    $('#editAddressModal button[type="submit"] span').removeClass("fa-pencil").addClass("fa-plus");
    $("#editAddressModal").modal('show');
  });

  //Validate address entered by user during update or add new address

  $('#editAddressForm input').on("keyup", function(){
    var cityv = $('#editAddressForm #city').val().trim();
    var statev = $('#editAddressForm #state').val().trim();
    var zipv = $('#editAddressForm #zip').val().trim();
    var numberv = $('#editAddressForm #number').val().trim();

    switch($(this).attr('id')){

      case "city" :
                        if(cityv != "" && addregexp.test(cityv)){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(cityv == ""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">city should contain alphabets only</p>");
                        }
      break;
      case "state" :
                        if(statev != "" && addregexp.test(statev)){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(statev == ""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">state should contain alphabets only</p>");
                        }
      break;
      case "zip" :
                    if(zipv != "" && zipregexp.test(zipv) && zipv.length == 6){
                      $(this).addClass("input_field_success_border");
                      $(this).next().remove();
                    }else if(zipv == ""){
                      $(this).next().remove();
                      $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                      $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                    }else{
                      $(this).next().remove();
                      $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                      $(this).after("<p class=\"text-danger bg-danger\">Zip code should contain letter (6 digits) only</Proxy()>");
                    }

      break;
      case "number" :
                      if(numberv != "" && numberregexp.test(parseInt(numberv)) && numberv.length == 10){
                        $(this).addClass("input_field_success_border");
                        $(this).next().remove();
                      }else if(numberv == ""){
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                      }else if(!numberregexp.test(parseInt(numberv))){
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Please enter valid phone number!</p>");
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Phone number should contain letter (10 digits) only</p>");
                      }

      break;
    } //Switch ends


  });   //onkeyup event ends

  //Address field validtion

  $('#editAddressForm #address').on("keyup",function(){
    var addressv = $(this).val().trim();
    if(addressv != ""){
      $(this).addClass("input_field_success_border");
      $(this).next().remove(); //Removing p if any
    }else{
      $(this).next().remove(); //Removing p if any to avoid multiple creations
      $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
      $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
    }
  });

});   //document ready function end


  //Validate edit address form on submission

  function validateEditAddressForm(){
    var flag = 0;
    $('#editAddressForm input').each(function(){
      var cityv = $('#editAddressForm #city').val().trim();
      var statev = $('#editAddressForm #state').val().trim();
      var zipv = $('#editAddressForm #zip').val().trim();
      var numberv = $('#editAddressForm #number').val().trim();


      switch($(this).attr('id')){

        case "city" :
                          if(cityv != "" && addregexp.test(cityv)){
                            $(this).addClass("input_field_success_border");
                            $(this).next().remove();
                          }else if(cityv == ""){
                            $(this).next().remove();
                            $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                            $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                            flag = 1;
                          }else{
                            $(this).next().remove();
                            $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                            $(this).after("<p class=\"text-danger bg-danger\">city should contain alphabets only</p>");
                            flag = 1;
                          }
        break;
        case "state" :
                          if(statev != "" && addregexp.test(statev)){
                            $(this).addClass("input_field_success_border");
                            $(this).next().remove();
                          }else if(statev == ""){
                            $(this).next().remove();
                            $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                            $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                            flag = 1;
                          }else{
                            $(this).next().remove();
                            $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                            $(this).after("<p class=\"text-danger bg-danger\">state should contain alphabets only</p>");
                            flag = 1;
                          }
        break;
        case "zip" :
                      if(zipv != "" && zipregexp.test(zipv) && zipv.length == 6){
                        $(this).addClass("input_field_success_border");
                        $(this).next().remove();
                      }else if(zipv == ""){
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        flag = 1;
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Zip code should contain letter (6 digits) only</p>");
                        flag = 1;
                      }

        break;
        case "number" :
                        if(numberv != "" && numberregexp.test(parseInt(numberv)) && numberv.length == 10){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(numberv == ""){
                          $(this).next().not(".gen_otp_btn").remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                          flag = 1;
                        }else if(!numberregexp.test(parseInt(numberv))){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">Please enter valid phone number!</p>");
                          flag = 1;
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">Phone number should contain letter (10 digits) only</p>");
                          flag = 1;
                        }
        break;
      } //Switch ends

      //To break the each function after error found
        if(flag == 1){
          return false;
        }

    });   //each function end

    var addressv = $('#editAddressForm #address').val().trim();
    if(addressv != ""){
      $('#editAddressForm #address').addClass("input_field_success_border");
      $('#editAddressForm #address').next().remove(); //Removing p if any
    }else{
      $('#editAddressForm #address').next().remove(); //Removing p if any to avoid multiple creations
      $('#editAddressForm #address').removeClass("input_field_success_border").addClass("input_field_error_border");
      $('#editAddressForm #address').after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
      flag = 1;
    }

    //To stop form from submission

    if(flag == 1){
      return false;
    }else{
      return true;
    }

  }   //main Function end


  //Validate checkout form on submission wether address and payment options are selected or not
  function validateCheckoutForm(e){
    if($("input[name='address_choice']").is(":checked") == false){
      $("#checkout_error_text").html("Please select address!");
      $("#validateErrorModal").modal("show");
      return false;
    }
    if($("input[name='payment_option']").is(":checked") == false){
      $("#checkout_error_text").html("Please select payment option!");
      $("#validateErrorModal").modal("show");
      return false;
    }

    return confirm("You will given 10 minutes for completing this transaction after that this product will be displayed to other users also and product may or may not be available!");

    /*$('#confirm').modal({ backdrop: 'static', keyboard: false })
        .one('click', '#confirm-btn', function() {
          return confirm("ok?");
        });*/
  }
