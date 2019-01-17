<?php
session_start();

include("db.php");

if($_POST['id'])
{
$id=$_POST['id'];

//User Details

if(isset($_SESSION['username'])){
	
$Uname = $_SESSION['username'];

if($UserSql = $mysqli->query("SELECT * FROM users WHERE username='$Uname'")){

    $UserRow = mysqli_fetch_array($UserSql);

	$Uid = $UserRow['id'];

    $UserSql->close();
}else{
	
     printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");

}

//End User Details


$id = $mysqli->escape_string($id);

//Verify IP address in favip table

$user_sql=$mysqli->query("SELECT user_id, ad_id FROM favorites WHERE ad_id='$id' AND user_id='$Uid'");

$count = $user_sql->num_rows;

if($count==0)
{
// Update Vote.
$mysqli->query("UPDATE ads SET favs=favs+1 WHERE id='$id'");

// Insert IP address and Message Id in favip table.
$mysqli->query("INSERT INTO favorites (ad_id, user_id) values ('$id','$Uid')");

//disply results
$result=$mysqli->query("SELECT * FROM ads WHERE id='$id'");
$row=mysqli_fetch_array($result);
$Totalfavorites=$row['favs'];

echo '<div class="ad-info-2"> <span class="contact-icons fa fa-star"></span>
          <div class="contact-p">You favorited this ad</div>
        </div>';

}else {

// Update Vote.
$mysqli->query("UPDATE ads SET favs=favs-1 WHERE id='$id'");

// Insert IP address and Message Id in favip table.
$mysqli->query("DELETE FROM favorites WHERE ad_id='$id' AND user_id='$Uid'");

//disply results
$result=$mysqli->query("SELECT * FROM ads WHERE id='$id'");
$row=mysqli_fetch_array($result);
$Totalfavorites=$row['favs'];

echo '<div class="ad-info-2"> <span class="contact-icons fa fa-star"></span>
          <div class="contact-p">Add to favorites</div>
        </div>';

}

}

}
?>