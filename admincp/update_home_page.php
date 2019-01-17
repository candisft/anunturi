<?php

include('../db.php');

$UploadDirectory	= '../images/'; //Upload Directory, ends with slash & make sure folder exist

if (!@file_exists($UploadDirectory)) {
	//destination folder does not exist
	die('<div class="alert alert-danger">Make sure Upload directory exist!</div>');
}

if($_POST)
{	

	
	$LineOne			= $mysqli->escape_string($_POST['inputLineOne']); // file title
	$LineTwo			= $mysqli->escape_string($_POST['inputLineTwo']); // file title
	
	
	if(isset($_FILES['inputfile']))
	{

	
	if($_FILES['inputfile']['error'])
	{
		//File upload error encountered
		die(upload_errors($_FILES['inputfile']['error']));
	}
	
	$Logo				= strtolower($_FILES['inputfile']['name']); //uploaded file name
	$ImageExt			= substr($Logo, strrpos($Logo, '.')); //file extension
	$FileType			= $_FILES['inputfile']['type']; //file type
	$FileSize			= $_FILES['inputfile']["size"]; //file size
		
	switch(strtolower($FileType))
	{
		//allowed file types
		case 'image/jpeg': //jpeg file
			break;
		default:
			die('<div class="alert alert-danger" role="alert">Unsupported file! Please upload JPEG file as your promo image.</div>'); //output error
	}
	
  
	$NewLogoName = 'promo'.$ImageExt;
   //Rename and save uploded file to destination folder.
   if(move_uploaded_file($_FILES['inputfile']["tmp_name"], $UploadDirectory . $NewLogoName ))
   {
		
// Insert info into database table.. do w.e!
	$mysqli->query("UPDATE settings SET htitle='$LineOne', hdisc='$LineTwo' WHERE id=1");
	
	}	
   }else{ // end checking logo upload
   
 	$mysqli->query("UPDATE settings SET htitle='$LineOne', hdisc='$LineTwo' WHERE id=1");
   
    }

		die('<div class="alert alert-success" role="alert">Home page settings updated successfully.</div>');

		
   }else{
   		die('<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>');
  
}

if(isset($_FILES['inputfile']))
	{
//function outputs upload error messages, http://www.php.net/manual/en/features.file-upload.errors.php#90522
function upload_errors($err_code) {
	switch ($err_code) { 
        case UPLOAD_ERR_INI_SIZE: 
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini'; 
        case UPLOAD_ERR_FORM_SIZE: 
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; 
        case UPLOAD_ERR_PARTIAL: 
            return 'The uploaded file was only partially uploaded'; 
        case UPLOAD_ERR_NO_FILE: 
            return 'No file was uploaded'; 
        case UPLOAD_ERR_NO_TMP_DIR: 
            return 'Missing a temporary folder'; 
        case UPLOAD_ERR_CANT_WRITE: 
            return 'Failed to write file to disk'; 
        case UPLOAD_ERR_EXTENSION: 
            return 'File upload stopped by extension'; 
        default: 
            return 'Unknown upload error'; 
    } 
} 
	}//End Logo upload
?>