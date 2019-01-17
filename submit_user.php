<?php
include('db.php');

if($_POST)
{	
	
	if(!isset($_POST['inputName']) || strlen($_POST['inputName'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please let us know your username.</div>');
	}
	
	$get_user = $mysqli->escape_string($_POST['inputName']);
	
	if($user_check = $mysqli->query("SELECT username FROM users WHERE username='$get_user'")){

   	$username_row = mysqli_fetch_array($user_check);
	
	$username_exsist = $username_row['username'];

   	$user_check->close();
   
	}else{
   
     printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");

	}
	
	if ($_POST['inputName'] == $username_exsist)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Username already taken. Please try another.</div>');
	}
	
	if(!isset($_POST['inputName']) || strlen($_POST['inputName'])<3)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Username must be more then 3 characters long.</div>');
	}
	
	if(!isset($_POST['inputEmail']) || strlen($_POST['inputEmail'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please let us know your email adress.</div>');
	}
	
	$email_address = $_POST['inputEmail'];
	
	if($email_check = $mysqli->query("SELECT email FROM users WHERE email='$email_address'")){

   	$email_row = mysqli_fetch_array($email_check);
	
	$email_exsist = $email_row['email'];

   	$email_check->close();
   
	}else{
   
     printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");

	}
	
	if ($_POST['inputEmail'] == $email_exsist)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Email address already in use.</div>');
	}
		
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
	
	if(!isset($_POST['inputPassword']) || strlen($_POST['inputPassword'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please provide a password.</div>');
	}
	
	if(!isset($_POST['inputPassword']) || strlen($_POST['inputPassword'])<6)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Password must be least 6 characters long.</div>');
	}
		if(!isset($_POST['inputcPassword']) || strlen($_POST['inputcPassword'])< 1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please enter the same password as above.</div>');
	}
	
	if ($_POST['inputPassword']!== $_POST['inputcPassword'])
 	{
		//required variables are empty
     	echo('<div class="alert alert-danger" role="alert">Oops! Password did not match! Try again.</div>');
 	
	}
	
			
	
	$UserName  			= $mysqli->escape_string($_POST['inputName']); // Username
	$Email  			= $mysqli->escape_string($_POST['inputEmail']); // Email
	$Phone  			= $mysqli->escape_string($_POST['inputPhone']); // Password
	$State  			= $mysqli->escape_string($_POST['inputState']); // Password
	if (isset($_POST['inputShowNmber'])) {
	$hide_phone 			= 2; 
	}else{
	$hide_phone 			= 1;		
	}
	$Password  			= $mysqli->escape_string($_POST['inputPassword']); // Password
	$EnPassword         = md5($Password); // Encript Password
	$RegDate		    = date("F j, Y"); //date
	
	
		
// Insert info into database table.. do w.e!
		$mysqli->query("INSERT INTO users(username, email, password, phone, showno, location, date) VALUES ('$UserName', '$Email', '$EnPassword','$Phone','$hide_phone','$State','$RegDate')");
		
?>
<script type="text/javascript">

$(document).ready(function()
{
var $tabs = $('.nav-tabs li');
var delay = 1000;
setTimeout(function() {

$tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
}, delay);
});

</script>
<?php		
		
		die('<div class="alert alert-success" role="alert">Thank you for Registering. Please wait while we redirect you.</div>');
		

   }else{
   		die('<div class="alert alert-danger" role="alert">There seems to be a problem. Please try again.</div>');
   } 

?>