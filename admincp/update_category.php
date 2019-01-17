<?php

include('../db.php');

$id = $mysqli->escape_string($_GET['id']);


//Get cat icon

if($icon_info = $mysqli->query("SELECT id, cat_image FROM categories WHERE id='$id'")){
	
	$get_icon = mysqli_fetch_array($icon_info);
	
	$icon = $get_icon['cat_image'];
	
$icon_info->close();
	
}else{
    
	 printf("There Seems to be an issue");
}


$UploadDirectory	= '../icons/';
 

if (!@file_exists($UploadDirectory)) {
	//destination folder does not exist
	die("Make sure Upload directory exist!");
}

if($_POST)
{	

	if(!isset($_POST['inputTitle']) || strlen($_POST['inputTitle'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger">Please enter desired category.</div>');
	}
	
	if(!isset($_POST['inputDescription']) || strlen($_POST['inputDescription'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger">Please enter description for your new category.</div>');
	}
	

	$CategoryTitle			= $mysqli->escape_string($_POST['inputTitle']);	
	$CategoryDescription	= $mysqli->escape_string($_POST['inputDescription']);
	
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
	$RandNumber   		= rand(0, 9999999999);
	
	
	switch(strtolower($FileType))
	{
		//allowed file types
		case 'image/png': //jpeg file
			break;
		default:
			die('<div class="alert alert-danger" role="alert">Unsupported Image File. Please upload PNG files</div>'); //output error
	}
	
	function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	
  
	$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($CategoryTitle));
	$NewFileName = clean($NewFileName);
	$NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;


   if(move_uploaded_file($_FILES['inputImage']["tmp_name"], $UploadDirectory . $NewFileName ))
  {
	  
  if(!empty($icon)){

	unlink("../icons/$icon");	
	
   }


$mysqli->query("UPDATE categories SET cname='$CategoryTitle', cat_description='$CategoryDescription', cat_image='$NewFileName' WHERE id='$id'");	

}

}else{
	   
$mysqli->query("UPDATE categories SET cname='$CategoryTitle', cat_description='$CategoryDescription' WHERE id='$id'");	 	   

}


	die('<div class="alert alert-success" role="alert">Category updated successfully.</div>');

		
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