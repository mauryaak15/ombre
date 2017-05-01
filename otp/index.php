<html>
<head>
  <script type="text/javascript" src="jquery-2.2.0.min.js"></script>
  <script type="text/javascript">
    function sendOTP() {
      var data = {
        "countryCode": $('#country_code').val(),
        "mobileNumber": $('#number').val()
      };
      $.ajax({
        url: 'sendotp.php?action=generateOTP',
        type: 'POST',
        data: data,
        success: function (response) {
          if (response == 'OTP SENT SUCCESSFULLY') {
            $('#hiddenCode').val($('#country_code').val());
            $('#hiddenNumber').val($('#number').val());
            $('#verifyOtpForm').show();
            $('#sendOtpForm').hide();
            $('#alertMessage').html(response+ " PLEASE VERIFY.");
          }
        },
        error: function (jqXHR, textStatus, ex) {
          console.log(textStatus + "," + ex + "," + jqXHR.responseText);
        }
      });
    }
    function verifyBySendOtp() {
      var data = {
        countryCode: $('#hiddenCode').val(),
        mobileNumber: $('#hiddenNumber').val(),
        oneTimePassword: $('#oneTimePassword').val()
      };
      $.ajax({
        url: 'sendotp.php?action=verifyBySendOtp',
        type: 'POST',
        data: data,
        success: function (response) {
          if (response == 'NUMBER VERIFIED SUCCESSFULLY') {
                $('#verifyOtpForm').hide();
                $('#sendOtpForm').show();
                $('#alertMessage').html(response+ " TRY AGAIN.");
          }
        },
        error: function (jqXHR, textStatus, ex) {
          console.log(textStatus + "," + ex + "," + jqXHR.responseText);
        }
      });
    }

  </script>
</head>
<body>
<pre>
<div id="alertMessage"></div>
<hr>
<div>
    <marquee><h1>TEST SendOTP Service</h1></marquee>
    <form id="sendOtpForm">
        <input type="text" name="country_code" placeholder="Country code" id="country_code"><br />
        <input type="text" name="number" placeholder="Mobile number" id="number"><br />
        <input type="button" name="sendOtp" id="sendOtp" value="Request OTP" onclick="sendOTP()"> 
    </form>
    <form id="verifyOtpForm" style="display:none">
      <input type="text" name="oneTimePassword" placeholder="Enter OTP" id="oneTimePassword">
      <input type="hidden" name="hiddenCode" id="hiddenCode">
      <input type="hidden" name="hiddenNumber" id="hiddenNumber">
      <input type="button" name="verifyOtp" id="verifyOtp" value="Verify OTP" onclick="verifyBySendOtp()">
    </form>
</div> 
<hr>
</pre>
</body>
</html>
