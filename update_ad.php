<?php

include('db.php');

$id = $mysqli->escape_string($_GET['id']);

if($get_ad = $mysqli->query("SELECT * FROM ads WHERE id='$id'")){

    $ad_row = mysqli_fetch_array($get_ad);
	
	$image       = stripslashes($ad_row['image']);
		
	$get_ad->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

$UploadDirectory	= 'uploads/';
 

if (!@file_exists($UploadDirectory)) {
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
	

	$Category			= $mysqli->escape_string($_POST['inputCategory']);
	$SubCategory		= $mysqli->escape_string($_POST['inputSubcat']);
	$Title				= $mysqli->escape_string($_POST['inputTitle']);
	$Description		= $mysqli->escape_string($_POST['inputDescription']);
	$Price				= $mysqli->escape_string($_POST['inputPrice']);
	$AdType				= $mysqli->escape_string($_POST['inputAdtype']);
	
	if(isset($_FILES['inputImage']))
	{
		
	if($_FILES['inputImage']['error'])
	{
		//File upload error encountered
		die(upload_errors($_FILES['inputImage']['error']));
	}
	
	$FileName			= strtolower($_FILES['inputImage']['name']); 
	$ImageExt			= substr($FileName, strrpos($FileName, '.')); 
	$FileType			= $_FILES['inputImage']['type']; 
	$FileSize			= $_FILES['inputImage']["size"]; 
	$RandNumber   		= rand(1111111111,9999999999);
	
	
	switch(strtolower($FileType))
	{
		//allowed file types
		case 'image/jpeg': //jpeg file
			break;
		default:
			die('<div class="alert alert-danger" role="alert">Unsupported Image File. Please upload JPEG files</div>'); //output error
	}
	
	function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	
  
	$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($Title));
	$NewFileName = clean($NewFileName);
	$NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;


   if(move_uploaded_file($_FILES['inputImage']["tmp_name"], $UploadDirectory . $NewFileName ))
  {
	
	   
	unlink("uploads/".$image);


$mysqli->query("UPDATE ads SET category='$Category', subcategory='$SubCategory', title='$Title', description='$Description', price='$Price', image='$NewFileName', type='$AdType' WHERE id=$id");	

}

}else{
	   
$mysqli->query("UPDATE ads SET category='$Category', subcategory='$SubCategory', title='$Title', description='$Description', price='$Price', type='$AdType' WHERE id=$id");	 	   


	   
 }


	die('<div class="alert alert-success" role="alert">You ad updated successfully.</div>');

		
   }else{
	   
   		die('<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>');
   }


if(!isset($_FILES['inputImage']))
	{
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
	}
?>