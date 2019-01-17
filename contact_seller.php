<?php
include ("db.php");

if($_POST)
{	
	if(!isset($_POST['inputYourname']) || strlen($_POST['inputYourname'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Scrie numele.</div>');
	}
	if(!isset($_POST['inputEmail']) || strlen($_POST['inputEmail'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Scrie o adresa de email corecta.</div');
	}
	
	$email_address = $_POST['inputEmail'];
	
	if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
  	// The email address is valid
	} else {
  		die('<div class="alert alert-danger" role="alert">Scrie o adresa de email corecta.</div>');
	}
	if(!isset($_POST['inputMessage']) || strlen($_POST['inputMessage'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Mesajul nu poate fi gol.</div>');
	}
if($SiteSettings = $mysqli->query("SELECT * FROM settings WHERE id='1'")){

    $Settings = mysqli_fetch_array($SiteSettings);
	
	$SiteSettings->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>A aprut o eroare</div>");
}

//Get ad info

$id = $mysqli->escape_string($_GET['id']);

if($get_ad = $mysqli->query("SELECT * FROM ads WHERE id='$id'")){

    $ad_row = mysqli_fetch_array($get_ad);
	
	$seller_id  = stripslashes($ad_row ['uid']);
	$full_title = stripslashes($ad_row ['title']);
	
	$page_link = preg_replace("![^a-z0-9]+!i", "-", $full_title);
	$page_link = urlencode($page_link);
	$page_link = strtolower($page_link);
	
	$get_ad->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>A aprut o eroare</div>");
}

//Sellet imfo

if($seller = $mysqli->query("SELECT * FROM users WHERE id='$seller_id'")){

    $seller_row = mysqli_fetch_array($seller);
		
	$seller->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>A aprut o eroare</div>");
}

$site_contact	     = $Settings['email'];
$site_url		     = $Settings['siteurl'];
$site_name           = $Settings['name'];
$from_name		     = $mysqli->escape_string($_POST['inputYourname']);
$from_email		 	 = $mysqli->escape_string($_POST['inputEmail']);
$seller_name		 = $seller_row['username'];
$seller_email		 = $seller_row['email'];
$subject	 		 = "You have recived a message regarding your ad at ".$Settings['email'];
$message	         = $mysqli->escape_string($_POST['inputMessage']);
$ad_url				 = '<a href="'.$site_url.'/ad-'.$id.'-'.$page_link.'.html">'.$full_title.'</a>';

$full_message = "<b>Ai primit un mesaj in legatura cu anuntu</b> <br/><br/>" .$ad_url. "<br/><br/><br/>De la: ".$from_name."<br/>Adresa: ".$from_email."<br/>Mesaj: ".$message."<br/><br/><br/>Raspunde la emailul ".$from_email.". Sau poti raspunde direct la acest email.";

require_once('include/class.phpmailer.php');

$mail             = new PHPMailer(); ;

$mail->AddReplyTo($from_email, $from_name);

$mail->SetFrom($site_contact, $site_name);

$mail->AddReplyTo($from_email, $from_name);

$mail->AddAddress($seller_email, $seller_name);

$mail->Subject = $subject;

$mail->MsgHTML($full_message);

if(!$mail->Send()) {?>

<div class="alert alert-danger" role="alert">Eroare la trimiterea emailului</div>

<?php } else {?>

<div class="alert alert-success" role="alert">Mesaj trimis. Vei primi un mesaj de la <?php echo $seller_name;?> la adresa ta de email</div>

<?php }

}

?>