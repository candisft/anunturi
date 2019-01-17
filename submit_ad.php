<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

include('db.php');

if($site_settings = $mysqli->query("SELECT * FROM settings WHERE id='1'")){

    $settings = mysqli_fetch_array($site_settings);
	
	$Active = $settings['active'];

    $site_settings->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");;

}

//Get user info

$get_username = $_SESSION['username'];

if($user_sql = $mysqli->query("SELECT * FROM users WHERE username='$get_username'")){

    $user_row = mysqli_fetch_array($user_sql);

	$user_id = $user_row['id'];
	
	$location = $user_row['location'];
	
    $user_sql->close();
	
}else{
     
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
	 
}

$upload_directory	= 'uploads/';
 

if (!@file_exists($upload_directory)) {
	//destination folder does not exist
	die("Make sure Upload directory exist!");
}

if($_POST)
{		
	if(!isset($_POST['inputCategory']) || strlen($_POST['inputCategory'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please select a category.</div>');
	}
	
	if(!isset($_POST['inputTitle']) || strlen($_POST['inputTitle'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please enter your ad title.</div>');
	}
	
	if(!isset($_POST['inputDescription']) || strlen($_POST['inputDescription'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please describe what your selling.</div>');
	}
	
	if(!isset($_POST['inputPrice']) || strlen($_POST['inputPrice'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please add the price</div>');
	}

		if(!isset($_FILES['inputImage']))
	{
		//required variables are empty
		die('<div class="alert alert-danger" role="alert">Please add a image.</div>');
	}
	
	if($_FILES['inputImage']['error'])
	{
		//File upload error encountered
		die(upload_errors($_FILES['inputImage']['error']));
	}
	

	$FileName			= strtolower($_FILES['inputImage']['name']);  
	$ImageExt			= substr($FileName, strrpos($FileName, '.')); 
	$FileType			= $_FILES['inputImage']['type']; 
	$FileSize			= $_FILES['inputImage']["size"]; 


if(isset($_FILES['inputImage2'])){
	$FileName2			= strtolower($_FILES['inputImage2']['name']); 
	$ImageExt2			= substr($FileName2, strrpos($FileName2, '.')); 
	$FileType2			= $_FILES['inputImage2']['type']; 
	$FileSize2			= $_FILES['inputImage2']["size"]; 
}

if(isset($_FILES['inputImage3'])){
	$FileName3			= strtolower($_FILES['inputImage3']['name']); 
	$ImageExt3			= substr($FileName3, strrpos($FileName3, '.')); 
	$FileType3			= $_FILES['inputImage3']['type']; 
	$FileSize3			= $_FILES['inputImage3']["size"]; 
}

	$RandNumber   		= rand(0,99999);
	$RandNumber2   		= rand(0,99999);
	$RandNumber3   		= rand(0,99999);  
	$Date		        = date("c",time());
	
	$Category			= $mysqli->escape_string($_POST['inputCategory']);
	$SubCategory		= $mysqli->escape_string($_POST['inputSubcat']);
	$Title				= $mysqli->escape_string($_POST['inputTitle']);
	$Description		= $mysqli->escape_string($_POST['inputDescription']);
	$Price				= $mysqli->escape_string($_POST['inputPrice']);
	$AdType				= $mysqli->escape_string($_POST['inputAdtype']);

	
	function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
  

	//Image File Title will be used as new File name
	$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($Title));
	$NewFileName = clean($NewFileName);
	$NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;

if(isset($_FILES['inputImage2'])){
	//Image File Title will be used as new File name
	$NewFileName2 = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($Title));
	$NewFileName2 = clean($NewFileName2);
	$NewFileName2 = $NewFileName2.'_'.$RandNumber2.$ImageExt2;

	move_uploaded_file($_FILES['inputImage2']["tmp_name"], $upload_directory . $NewFileName2 );
	}


if(isset($_FILES['inputImage3'])){
	//Image File Title will be used as new File name
	$NewFileName3 = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($Title));
	$NewFileName3 = clean($NewFileName3);
	$NewFileName3 = $NewFileName3.'_'.$RandNumber3.$ImageExt3;

	move_uploaded_file($_FILES['inputImage3']["tmp_name"], $upload_directory . $NewFileName3 );
	}


 //Rename and save uploded image file to destination folder.
   if(move_uploaded_file($_FILES['inputImage']["tmp_name"], $upload_directory . $NewFileName ))
   {
	
	
		
// Insert info into database table.. do w.e!
$mysqli->query("INSERT INTO ads(category, subcategory, title, description, price, image, image2, image3, location, date, uid, type, active) VALUES ('$Category','$SubCategory','$Title','$Description','$Price','$NewFileName','$NewFileName2','$NewFileName3','$location','$Date','$user_id','$AdType','$Active')");

?>

<script>
$('#from-ad').delay(1000).resetForm(1000);
$('#from-ad').delay(1000).slideUp(1000);
</script>

<?php

if($Active==0){
			
		die('<div class="alert alert-success" role="alert">Your ad was successfully submitted for review.</div>');

}else if($Active==1){

		die('<div class="alert alert-success" role="alert">Your ad submited successfully.</div>');	

}
   
   }else{
   		die('<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>');
   } 
}

function upload_errors($err_code) {
	switch ($err_code) { 
        case UPLOAD_ERR_INI_SIZE: 
            return '<div class="alert alert-danger" role="alert">Image file size is too big. Please try a smaller image</div>'; 
        case UPLOAD_ERR_FORM_SIZE: 
            return '<div class="alert alert-danger" role="alert">Image file size is too big. Please try a smaller image</div>'; 
        case UPLOAD_ERR_PARTIAL: 
            return '<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>'; 
        case UPLOAD_ERR_NO_FILE: 
            return '<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>'; 
        case UPLOAD_ERR_NO_TMP_DIR: 
            return '<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>'; 
        case UPLOAD_ERR_CANT_WRITE: 
            return '<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>'; 
        case UPLOAD_ERR_EXTENSION: 
            return '<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>'; 
        default: 
            return '<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>'; 
    }  
} 
?>