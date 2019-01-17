<?php
include("../db.php");
 
$Subcategory = $_POST['categoryId'];

?>

	  <option value="">Select Subcategory</option>

<?php

if($SubSelectTopics = $mysqli->query("SELECT * FROM categories WHERE parent_id='$Subcategory' ORDER BY cname ASC")){

    while($SubTopicRow = mysqli_fetch_array($SubSelectTopics)){
				
?>
      <option value="<?php echo $SubTopicRow['id'];?>"><?php echo $SubTopicRow['cname'];?></option>
<?php

}

	$SubSelectTopics->close();
	
}else{
    
	 printf("There Seems to be an issue");
}
?>

?>