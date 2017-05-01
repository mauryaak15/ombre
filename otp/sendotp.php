<?php
session_start();

class SendOTP
{
  private $baseUrl = "https://sendotp.msg91.com/api";

  public function callGenerateAPI($request)
  {
    $data = array("countryCode" => $request['countryCode'], "mobileNumber" => $request['mobileNumber'], "getGeneratedOTP" => true);
    $data_string = json_encode($data);
    $ch = curl_init($this->baseUrl . '/generateOTP');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string),
      'application-Key: 9jc_UPOgZQYw35NnoSWEGpvu3-yi7S9TfnljDrlW5SseDNK2MojbvG0avMbyvkIrkPGYYKPNlAuh3cIviZvWbjw0EXjNEAn14PQKBIcIqzAUMCFrQlPH_QQ-0PpRDzy4R45na6iqWBnHpp4YAahbog=='
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }

  public function saveOTP($OTP)
  {
    //save OTP to your session
    $_SESSION["oneTimePassword"] = $OTP;
    // OR save the OTP to your database
    //connect db and save it to a table
    return true;
  }

  public function generateOTP($request)
  {
    //call generateOTP API
    $response = $this->callGenerateAPI($request);
    $response = json_decode($response, true);
    if ($response["status"] == "error") {
      //customize this as per your framework
      echo $response["response"]["code"];
      return;
    }
    //save the OTP on your server
    if (isset($response["response"]["oneTimePassword"])) {
      if ($this->saveOTP($response["response"]["oneTimePassword"])) {
        echo "OTP SENT SUCCESSFULLY";
        return;
      } else {
        echo "OTP NOT SAVED SUCCESSFULLY";
      }
    } else {
      echo "OTP SENT SUCCESSFULLY";
    }
  }

  public function verifyOTP($request)
  {
    //This is the sudo logic you have to customize it as needed.
    //your verify logic here
    if ($request["oneTimePassword"] == $_SESSION["oneTimePassword"]) {
      echo "NUMBER VERIFIED SUCCESSFULLY";
      return;
    } else {
      echo "OTP INVALID";
      return;
    }
    // OR get the OTP from your db and check against the OTP from client
  }

  public function verifyBySendOtp($request)
  {
    $data = array("countryCode" => $request['countryCode'], "mobileNumber" => $request['mobileNumber'], "oneTimePassword" => $request['oneTimePassword']);
    $data_string = json_encode($data);
    $ch = curl_init($this->baseUrl . '/verifyOTP');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string),
      'application-Key: 9jc_UPOgZQYw35NnoSWEGpvu3-yi7S9TfnljDrlW5SseDNK2MojbvG0avMbyvkIrkPGYYKPNlAuh3cIviZvWbjw0EXjNEAn14PQKBIcIqzAUMCFrQlPH_QQ-0PpRDzy4R45na6iqWBnHpp4YAahbog=='
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($result, true);
    if ($response["status"] == "error") {
      //customize this as per your framework
      echo $response["response"]["code"];
      return;
    } else {
		$_SESSION['refreshToken'] = $response["response"]["refreshToken"];
      echo "NUMBER VERIFIED SUCCESSFULLY";
    }
  }
}

$sendOTPObject = new SendOTP();
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
  echo $sendOTPObject->$_REQUEST['action']($_REQUEST);
} else {
  echo "Error Wrong api";
}
?>