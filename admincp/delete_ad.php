<?php

include("../db.php");

$del = $mysqli->escape_string($_POST['id']);

if($ImageInfo = $mysqli->query("SELECT * FROM ads WHERE id='$del'")){

    $GetInfo = mysqli_fetch_array($ImageInfo);
	
	$CheckImage = $ImageInfo->num_rows;
	
	$Image = $GetInfo['image'];
	
	$ImageInfo->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

if($CheckImage==1){

unlink("../uploads/$Image");

}


$DeletePosts = $mysqli->query("DELETE FROM ads WHERE id='$del'");


echo '<div class="alert alert-success" role="alert">Ad deleted successfully.</div>';

?>