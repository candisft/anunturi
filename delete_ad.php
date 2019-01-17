<?php

include("db.php");

$del = $mysqli->escape_string($_POST['id']);

if($get_ad = $mysqli->query("SELECT * FROM ads WHERE id='$del'")){
	
	$ad_row = mysqli_fetch_array($get_ad);
	
	$get_image = $ad_row['image'];
	
	$get_ad->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

if(!empty($get_image)){
	
unlink("uploads/$get_image");

}

$mysqli->query("DELETE FROM ads WHERE id='$del'");



echo '<div class="alert alert-success" role="alert">Ad successfully deleted.</div>';

?>