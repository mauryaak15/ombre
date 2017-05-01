//Regular Expressions

var addregexp = /^[a-zA-Z_ ]*$/;    //Regexp for state and city
var zipregexp = /^[0-9\-_]{6}$/;  //Regexp for zipcode
var numberregexp = /^[^0-6][0-9\-_]{0,10}$/;  //Regexp for mobile number
var emailregexp = /^[a-z][a-zA-Z0-9_]*(\.[a-zA-Z][a-zA-Z0-9_]*)?@[a-z][a-zA-Z-0-9]*\.[a-z]+(\.[a-z]+)?$/;   //Regexp for email
var passregexp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/;   //Regexp for password

//On change of input field validation
var numberValid = false;
var otpverified = false;
$(document).ready(function(){

  $('input').on("keyup", function(){
    var fnamev = $('#fname').val().trim();
    var lnamev = $('#lname').val().trim();
    var usernamev = $('#username').val().trim();
    var cityv = $('#city').val().trim();
    var statev = $('#state').val().trim();
    var zipv = $('#zip').val().trim();
    var numberv = $('#number').val().trim();
    var emailv = $('#email').val().trim();
    var cnfemailv = $('#cnfemail').val().trim();
    var passwordv = $('#password').val().trim();
    var cnfpasswordv = $('#cnfpassword').val().trim();


    switch($(this).attr('id')){
      case "fname" :
                      if(fnamev != ""){
                        $(this).addClass("input_field_success_border");
                        $(this).next().remove(); //Removing p if any
                      }else{
                        $(this).next().remove(); //Removing p if any to avoid multiple creations
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                      }
      break;
      case "lname" :
                      if(lnamev != ""){
                        $(this).addClass("input_field_success_border");
                        $(this).next().remove();
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                      }
      break;
      case "username" :
                        var current_input = $(this);
                        if(usernamev ==""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        }else{
                          $.ajax({
                            type:"POST",
                            url :"ajax_regForm_check_db_request.php",
                            data:"username="+usernamev,
                            cache:false,
                            success: function(result){
                              if(result.trim() == '1'){
                                current_input.addClass("input_field_success_border");
                                current_input.next().remove();
                              }else{
                                current_input.next().remove();
                                current_input.removeClass("input_field_success_border").addClass("input_field_error_border");
                                current_input.after("<p class=\"text-danger bg-danger\">"+usernamev+" not available!</p>");
                              }
                            }
                          });

                        }
      break;
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
                      var current_input = $(this);
                      if(numberv != "" && numberregexp.test(parseInt(numberv)) && numberv.length == 10){
                          $.ajax({
                            type:"POST",
                            url :"ajax_regForm_check_db_request.php",
                            data:"number="+numberv,
                            cache:false,
                            success: function(result){
                              if(result.trim() == '1'){
                                current_input.addClass("input_field_success_border");
                                current_input.next().not(".gen_otp_btn").remove();
                                numberValid = true;
                                if(numberValid){
                                  $('.gen_otp_btn').removeAttr("disabled");
                                }

                              }else{
                                current_input.next().not(".gen_otp_btn").remove();
                                current_input.removeClass("input_field_success_border").addClass("input_field_error_border");
                                current_input.after("<p class=\"text-danger bg-danger\">"+numberv+" is already registered!</p>");
                                numberValid = false;
                              }
                            }
                          });
                      }else if(numberv == ""){
                        $(this).next().not(".gen_otp_btn").remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        numberValid = false;
                      }else if(!numberregexp.test(parseInt(numberv))){
                        $(this).next().not(".gen_otp_btn").remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        numberValid = false;
                        $(this).after("<p class=\"text-danger bg-danger\">Please enter valid phone number!</p>");
                      }else{
                        $(this).next().not(".gen_otp_btn").remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Phone number should contain letter (10 digits) only</p>");
                        numberValid = false;
                      }
      break;
      case "email" :
                      var current_input = $(this);
                      if(emailv != "" && emailregexp.test(emailv)){
                          $.ajax({
                            type:"POST",
                            url :"ajax_regForm_check_db_request.php",
                            data:"email="+emailv,
                            cache:false,
                            success: function(result){
                              if(result.trim() == '1'){
                                current_input.addClass("input_field_success_border");
                                current_input.next().remove();
                              }else{
                                current_input.next().remove();
                                current_input.removeClass("input_field_success_border").addClass("input_field_error_border");
                                current_input.after("<p class=\"text-danger bg-danger\">"+emailv+" is already registered!</p>");
                              }
                            }
                          });
                      }else if(emailv == ""){
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Please enter valid email address!</p>");
                      }
                      //If email field is changed after confirming the email
                      if(cnfemailv !=""){
                        if(cnfemailv == emailv){
                          $('#cnfemail').addClass("input_field_success_border");
                          $('#cnfemail').next().remove();
                        }else{
                          $('#cnfemail').next().remove();
                          $('#cnfemail').removeClass("input_field_success_border").addClass("input_field_error_border");
                          $('#cnfemail').after("<p class=\"text-danger bg-danger\">Email address must be same as above</p>");
                        }
                      }

      break;
      case "cnfemail" :

                        if(cnfemailv == emailv && emailv != ""){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(cnfemailv == ""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">Email address must be same as above</p>");
                        }

      break;
      case "password" :
                        if(passwordv != "" && passregexp.test(passwordv)){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(passwordv == ""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">Password must conatin lowercase and uppercase alphabets,numbers, special characters and minimum of 8 characters</p>");
                        }
                        //If password field is changed after confirming the password
                        if(cnfpasswordv !=""){
                          if(cnfpasswordv == passwordv){
                            $('#cnfpassword').addClass("input_field_success_border");
                            $('#cnfpassword').next().remove();
                          }else{
                            $('#cnfpassword').next().remove();
                            $('#cnfpassword').removeClass("input_field_success_border").addClass("input_field_error_border");
                            $('#cnfpassword').after("<p class=\"text-danger bg-danger\">Password must be same as above</p>");
                          }
                        }
      break;
      case "cnfpassword" :
                            if(cnfpasswordv == passwordv && passwordv != ""){
                              $(this).addClass("input_field_success_border");
                              $(this).next().remove();
                            }else if(cnfpasswordv == ""){
                              $(this).next().remove();
                              $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                              $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                            }else{
                              $(this).next().remove();
                              $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                              $(this).after("<p class=\"text-danger bg-danger\">Password must be same as above</p>");
                            }
      break;
    } //Switch ends

    if(!numberValid){
      $('.gen_otp_btn').attr("disabled","disabled");
    }else{
      $('.gen_otp_btn').removeAttr("disabled");
    }

  });   //onkeyup event ends

  //Terms and conditions agreement checkbox working

  $("#agree").change(function(){
    if($(this).is(':checked')){
      $('button[type="submit"]').removeAttr("disabled").removeAttr("title","Please agree to terms and conditions");
    }else{
      $('button[type="submit"]').attr("disabled","disabled").attr("title","Please agree to terms and conditions");
    }
  });

  //Address field validtion

  $('#address').on("keyup",function(){
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

  //OTP Generation

  $('.gen_otp_btn').on("click",function(){
      var num_length = $('#number').val().length;
      if(numberValid && num_length == 10){
        var num = $('#number').val();
          $.ajax({
            url: 'otp/sendotp.php?action=generateOTP',
            type: 'POST',
            data: "countryCode=91&mobileNumber="+num,
            success: function (response) {
              if (response == 'OTP SENT SUCCESSFULLY') {
                $('.numberdiv').addClass("hide");
                $(".gen_otp_btn").addClass("hide");
                $('#OTPGenFail').addClass("hide");
                $(".otpdiv").removeClass("hide");
                $(".verify_otp_btn").removeClass("hide");
                $(".resend_otp_btn").removeClass("hide");
                $("#invalidOTPmsg").removeClass("hide text-danger bg-danger").addClass("text-success bg-success").html("OTP SENT SUCCESSFULLY");
              }else{
                $('#OTPGenFail').removeClass("hide").html(response);
              }
            }

          });   //Ajax otp gen call ends

      }

  });   //onclick event ends

  //Resend OTP

  $('.resend_otp_btn').on("click", function(){
    var num_length = $('#number').val().length;
    if(numberValid && num_length == 10){
      var num = $('#number').val();
        $.ajax({
          url: 'otp/sendotp.php?action=generateOTP',
          type: 'POST',
          data: "countryCode=91&mobileNumber="+num,
          success: function (response) {
            if (response == 'OTP SENT SUCCESSFULLY') {
              $("#invalidOTPmsg").removeClass("hide text-danger bg-danger").addClass("text-success bg-success").html("OTP SENT SUCCESSFULLY");
            }else{
              $("#invalidOTPmsg").removeClass("text-success bg-success hide").addClass("text-danger bg-danger").html("Error in sending OTP Try again later");
            }
          }

        });   //Ajax otp gen call ends

    }
  });

  //OTP Verification
  $('.verify_otp_btn').on("click",function(){
      var otp_length = $('#otp').val().length;
      if(numberValid && otp_length == 4){
        var otp = $('#otp').val();
        var num = $('#number').val();
          $.ajax({
            url: 'otp/sendotp.php?action=verifyBySendOtp',
            type: 'POST',
            data: "countryCode=91&mobileNumber="+num+"&oneTimePassword="+otp,
            success: function (response) {
              if (response == 'NUMBER VERIFIED SUCCESSFULLY') {
                $(".otpdiv").addClass("hide");
                $(".verify_otp_btn").addClass("hide");
                $(".otpSuccessMsg").removeClass("hide");
                otpverified = true;
              }else{
                $('#otp').addClass("input_field_error_border");
                $("#invalidOTPmsg").removeClass("text-success bg-success hide").addClass("text-danger bg-danger").html("Invalid OTP");
                otpverified = false;
              }
            }

          });   //Ajax otp verification call ends

      }else{
        $('#otp').addClass("input_field_error_border");
        $("#invalidOTPmsg").removeClass("text-success bg-success hide").addClass("text-danger bg-danger").html("Invalid OTP");
        otpverified = false;
      }

  });   //onclick event ends

  //Check phone verification status
  /*$('.check_status_btn').on("click",function(){
      var num_length = $('#number').val().length;
      if(numberValid && num_length == 10){
        var num = $('#number').val();
          $.ajax({
            url: 'otp/checkStatus.php',
            type: 'POST',
            data: "mobileNumber="+num,
            success: function (response) {
              if (response.trim() == 'NUMBER IS VERIFIED') {
                alert("Successfull");
              }else{
                alert(response);
              }
            }

          });   //Ajax mobile status call ends
        }else{
          alert("source is changed");
        }
      });   //on click event ends*/


}); //on ready function ends

//validate function is outisde document ready because onsubmit make document in process stage and therefore function become undefined on calling

//on submit validation function

function validateForm(){
  var flag = 0;
  $('input').each(function(){
    var fnamev = $('#fname').val().trim();
    var lnamev = $('#lname').val().trim();
    var usernamev = $('#username').val().trim();
    var cityv = $('#city').val().trim();
    var statev = $('#state').val().trim();
    var zipv = $('#zip').val().trim();
    var numberv = $('#number').val().trim();
    var emailv = $('#email').val().trim();
    var cnfemailv = $('#cnfemail').val().trim();
    var passwordv = $('#password').val().trim();
    var cnfpasswordv = $('#cnfpassword').val().trim();

    switch($(this).attr('id')){
      case "fname" :
                      if(fnamev != ""){
                        $(this).addClass("input_field_success_border");
                        $(this).next().remove();
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        flag = 1;
                      }
      break;
      case "lname" :
                      if(lnamev != ""){
                        $(this).addClass("input_field_success_border");
                        $(this).next().remove();
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        flag = 1;
                      }
      break;
      case "username" :
                        var current_input = $(this);
                        if(usernamev ==""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                          flag = 1;
                        }else{
                          $.ajax({
                            type:"POST",
                            url :"ajax_regForm_check_db_request.php",
                            data:"username="+usernamev,
                            cache:false,
                            success: function(result){
                              if(result.trim() == '1'){
                                current_input.addClass("input_field_success_border");
                                current_input.next().remove();
                              }else{
                                current_input.next().remove();
                                current_input.removeClass("input_field_success_border").addClass("input_field_error_border");
                                current_input.after("<p class=\"text-danger bg-danger\">"+usernamev+" not available!</p>");
                                flag = 1;
                              }
                            }
                          });

                        }
      break;
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
                      var current_input = $(this);
                      if(numberv != "" && numberregexp.test(parseInt(numberv)) && numberv.length == 10){
                          $.ajax({
                            type:"POST",
                            url :"ajax_regForm_check_db_request.php",
                            data:"number="+numberv,
                            cache:false,
                            success: function(result){
                              if(result.trim() == '1'){
                                current_input.addClass("input_field_success_border");
                                current_input.next().not(".gen_otp_btn").remove();
                                numberValid = true;
                                if(numberValid){
                                  $('.gen_otp_btn').removeAttr("disabled");
                                }
                              }else{
                                current_input.next().not(".gen_otp_btn").remove();
                                current_input.removeClass("input_field_success_border").addClass("input_field_error_border");
                                current_input.after("<p class=\"text-danger bg-danger\">"+numberv+" is already registered!</p>");
                                numberValid = false;
                                flag = 1;
                              }
                            }
                          });
                      }else if(numberv == ""){
                        $(this).next().not(".gen_otp_btn").remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        flag = 1;
                        numberValid = false;
                      }else if(!numberregexp.test(parseInt(numberv))){
                        $(this).next().not(".gen_otp_btn").remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Please enter valid phone number!</p>");
                        flag = 1;
                        numberValid = false;
                      }else{
                        $(this).next().not(".gen_otp_btn").remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Phone number should contain letter (10 digits) only</p>");
                        flag = 1;
                        numberValid = false;
                      }
      break;
      case "email" :
                      var current_input = $(this);
                      if(emailv != "" && emailregexp.test(emailv)){
                          $.ajax({
                            type:"POST",
                            url :"ajax_regForm_check_db_request.php",
                            data:"email="+emailv,
                            cache:false,
                            success: function(result){
                              if(result.trim() == '1'){
                                current_input.addClass("input_field_success_border");
                                current_input.next().remove();
                              }else{
                                current_input.next().remove();
                                current_input.removeClass("input_field_success_border").addClass("input_field_error_border");
                                current_input.after("<p class=\"text-danger bg-danger\">"+emailv+" is already registered!</p>");
                                flag = 1;
                              }
                            }
                          });
                      }else if(emailv == ""){
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                        flag = 1;
                      }else{
                        $(this).next().remove();
                        $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                        $(this).after("<p class=\"text-danger bg-danger\">Please enter valid email address!</p>");
                        flag = 1;
                      }
                      //If email field is changed after confirming the email
                      if(cnfemailv !=""){
                        if(cnfemailv == emailv){
                          $('#cnfemail').addClass("input_field_success_border");
                          $('#cnfemail').next().remove();
                        }else{
                          $('#cnfemail').next().remove();
                          $('#cnfemail').removeClass("input_field_success_border").addClass("input_field_error_border");
                          $('#cnfemail').after("<p class=\"text-danger bg-danger\">Email address must be same as above</p>");
                          flag = 1;
                        }
                      }

      break;
      case "cnfemail" :

                        if(cnfemailv == emailv && emailv != ""){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(cnfemailv == ""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                          flag = 1;
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">Email address must be same as above</p>");
                          flag = 1;
                        }

      break;
      case "password" :
                        if(passwordv != "" && passregexp.test(passwordv)){
                          $(this).addClass("input_field_success_border");
                          $(this).next().remove();
                        }else if(passwordv == ""){
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                          flag = 1;
                        }else{
                          $(this).next().remove();
                          $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                          $(this).after("<p class=\"text-danger bg-danger\">Password must conatin lowercase and uppercase alphabets,numbers, special characters and minimum of 8 characters</p>");
                          flag = 1;
                        }
                        //If password field is changed after confirming the password
                        if(cnfpasswordv !=""){
                          if(cnfpasswordv == passwordv){
                            $('#cnfpassword').addClass("input_field_success_border");
                            $('#cnfpassword').next().remove();
                          }else{
                            $('#cnfpassword').next().remove();
                            $('#cnfpassword').removeClass("input_field_success_border").addClass("input_field_error_border");
                            $('#cnfpassword').after("<p class=\"text-danger bg-danger\">Password must be same as above</p>");
                            flag = 1;
                          }
                        }
      break;
      case "cnfpassword" :
                            if(cnfpasswordv == passwordv && passwordv != ""){
                              $(this).addClass("input_field_success_border");
                              $(this).next().remove();
                            }else if(cnfpasswordv == ""){
                              $(this).next().remove();
                              $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                              $(this).after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
                              flag = 1;
                            }else{
                              $(this).next().remove();
                              $(this).removeClass("input_field_success_border").addClass("input_field_error_border");
                              $(this).after("<p class=\"text-danger bg-danger\">Password must be same as above</p>");
                              flag = 1;
                            }
      break;
    } //Switch ends

    //To break the each function after error found
      if(flag == 1){
        return false;
      }

  });   //each function end

  var addressv = $('#address').val().trim();
  if(addressv != ""){
    $('#address').addClass("input_field_success_border");
    $('#address').next().remove(); //Removing p if any
  }else{
    $('#address').next().remove(); //Removing p if any to avoid multiple creations
    $('#address').removeClass("input_field_success_border").addClass("input_field_error_border");
    $('#address').after("<p class=\"text-danger bg-danger\">This field can\'t be empty!</p>");
    flag = 1;
  }

  //To stop form from submission

  if(flag == 1){
    return false;
  }
  if(otpverified==false){
    $("#otp").addClass("input_field_error_border");
    $("#invalidOTPmsg").removeClass("text-success bg-success hide").addClass("text-danger bg-danger").html("Enter OTP");
    return false;
  }


}
