<?php 
	//Constants for our API
	//this is applicable only when you are using Cheap SMS Bazaar
	define('SMSUSER','leewayne95);
	define('PASSWORD','leewayne95');
	define('SENDERID','1995);
	
	
	//This function will send the otp 
	function sendOtp($otp, $phone){
		//This is the sms text that will be sent via sms 
		$sms_content = "Welcome to Simplified Coding: Your verification code is $otp";
		
		//Encoding the text in url format
		$sms_text = urlencode($sms_content);

		//This is the Actual API URL concatnated with required values 
		$api_url = 'http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user='.SMSUSER.'&password='.PASSWORD.'&msisdn=91'.$phone.'&sid='.SENDERID.'&msg='.$sms_text.'&fl=0&gwid=2';
		
		//Envoking the API url and getting the response 
		$response = file_get_contents( $api_url);
		
		//Returning the response 
		return $response;
	}
	
	
	//If a post request comes to this script 
	if($_SERVER['REQUEST_METHOD']=='POST'){	
		//getting username password and phone number 
		$surname = $_POST['surname'];
		$name = $_POST['name'];
		$password = $_POST[password];
		$cellno = $_POST[cell_no];
		$userid = $_POST[user_id];
		//Generating a 6 Digits OTP or verification code 
		$otp = rand(100000, 999999);
		
		//Importing the db connection script 
		require_once('dbConnect.php');
		
		//Creating an SQL Query 
		$sql = "INSERT INTO tbl_user (surname,name, password, cell_no,user_id, otp) values ('$surname','$name','$password','$cellno','userid ','$otp')";
		
		//If the query executed on the db successfully 
		if(mysqli_query($con,$sql)){
			//printing the response given by sendOtp function by passing the otp and phone number 
            echo sendOtp($otp,$phone);
		}else{
			//printing the failure message in json 
			echo '{"ErrorMessage":"Failure"}';
		}
		
		//Closing the database connection 
		mysqli_close($con);
	}