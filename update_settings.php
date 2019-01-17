<?php
session_start();

include('db.php');

if(isset($_SESSION['username'])){


if($_POST)
{	

	$id = $mysqli->escape_string($_GET['id']);
	
	if(!isset($_POST['inputEmail']) || strlen($_POST['inputEmail'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please let us know your email adress.</div>');
	}
	
	$email_address = $_POST['inputEmail'];
	
	if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
  	// The email address is valid
	} else {
  		die('<div class="alert alert-danger" role="alert">Come on!! This is not a real email address.</div>');
	}
	
	if(!isset($_POST['inputState']) || strlen($_POST['inputState'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please let us know your location.</div>');
	}
	
		
	$Email  			= $mysqli->escape_string($_POST['inputEmail']); // Email
	$Phone  			= $mysqli->escape_string($_POST['inputPhone']); // Password
	$State  			= $mysqli->escape_string($_POST['inputState']); // Password
	if (isset($_POST['inputShowNmber'])) {
	$hide_phone 			= 2; 
	}else{
	$hide_phone 			= 1;		
	} 
	
		
// Update info into database table.. do w.e!
		$mysqli->query("UPDATE users SET email='$Email', phone='$Phone',  showno='$hide_phone', location='$State' WHERE id='$id'");
		
		
		die('<div class="alert alert-info">Settings updated successfully.</div>');
		

   }else{
   		die('<div class="alert alert-danger">There seems to be a problem. Please try again.</div>');
   } 
}

?>