<?php

include("../db.php");

$del = $mysqli->escape_string($_POST['id']);

//Delete Listing Images

if($ImageInfo = $mysqli->query("SELECT * FROM ads WHERE category='$del'")){

    $CountImages = $ImageInfo->num_rows;
	
	while($GetInfo = mysqli_fetch_array($ImageInfo)){
	
	$Image = $GetInfo['image'];
	
if ($CountImages>0){

if(!empty($Image)){

unlink("../uploads/$Image");

}

}

}
	
$ImageInfo->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

//Get cat icon

if($icon_info = $mysqli->query("SELECT id, cat_image FROM categories WHERE id='$del'")){
	
	$get_icon = mysqli_fetch_array($icon_info);
	
	$icon = $get_icon['cat_image'];
	
$icon_info->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

if(!empty($icon)){

unlink("../icons/$icon");	

}

//Delete Ads

$mysqli->query("DELETE FROM ads WHERE id='$del'");

//Delete Catagories

$mysqli->query("DELETE FROM categories WHERE id='$del'");



echo '<div class="alert alert-success" role="alert">Category successfully deleted</div>';

?>