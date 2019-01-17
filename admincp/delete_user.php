<?php

include("../db.php");

$del = $mysqli->escape_string($_POST['id']);


if($ImageInfo = $mysqli->query("SELECT * FROM ads WHERE uid='$del'")){

	$CheckImage = $ImageInfo->num_rows;
	
    while($GetInfo = mysqli_fetch_array($ImageInfo)){
		
	$Image = $GetInfo['image'];
	
if($CheckImage>0){

if(!empty($Image)){

	unlink("../uploads/$Image");

}
}	

}
	
	$ImageInfo->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}




$mysqli->query("DELETE FROM ads WHERE uid='$del'");


$mysqli->query("DELETE FROM users WHERE id='$del'");

echo '<div class="alert alert-success" role="alert">User deleted successfully.</div>';

?>