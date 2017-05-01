<?php
session_start();

   if(isset($_POST['mobileNumber'])&&!empty($_POST['mobileNumber'])) {
	    $baseUrl = "http://sendotp.msg91.com/api";
		$refreshToken = "";
		$mobileNumber = $_POST['mobileNumber'];
	   if(isset($_SESSION['refreshToken'])){
		    $refreshToken = $_SESSION['refreshToken'];
		   }
       $ch = $ch = curl_init($baseUrl."/checkNumberStatus?refreshToken=".$refreshToken."&countryCode=91&mobileNumber=".$mobileNumber);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_AUTOREFERER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'application-key : 9jc_UPOgZQYw35NnoSWEGpvu3-yi7S9TfnljDrlW5SseDNK2MojbvG0avMbyvkIrkPGYYKPNlAuh3cIviZvWbjw0EXjNEAn14PQKBIcIqzAUMCFrQlPH_QQ-0PpRDzy4R45na6iqWBnHpp4YAahbog=='
       ));
       $result = curl_exec($ch);
       curl_close($ch);
	   $response = json_decode($result, true);
	   if ($response["status"] == "error") {
      //customize this as per your framework
      echo $response["response"]["code"];
      return;
    } else {
		echo "NUMBER IS VERIFIED";
    }
   }

?>	