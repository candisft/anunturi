<?php

include("../db.php");

//Get Site Settings

if($SiteSettings = $mysqli->query("SELECT * FROM settings WHERE id='1'")){

    $Settings = mysqli_fetch_array($SiteSettings);
	
	$SiteLink = $Settings['siteurl'];
	
	$SiteSettings->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

$id = $mysqli->escape_string($_GET['id']);

	//Get ad info

if($get_ad = $mysqli->query("SELECT * FROM ads WHERE id='$id'")){

    $ad_row = mysqli_fetch_array($get_ad);
	
	$seller_id 		= stripslashes($ad_row['uid']);
	$feat_image 	= stripslashes($ad_row['image']);
	$ad_type 		= stripslashes($ad_row['type']);
	$ad_cat_id		= stripslashes($ad_row['category']);
	$ad_subcat_id	= stripslashes($ad_row['subcategory']);
	
	$full_title = stripslashes($ad_row['title']);
	$page_link = preg_replace("![^a-z0-9]+!i", "-", $full_title);
	$page_link = urlencode($page_link);
	$page_link = strtolower($page_link);	
	
	$full_description = stripslashes($ad_row['description']);
	$crop_description = strlen ($full_title);
	if ($crop_description > 160) {
	$sort_description = substr($full_description,0,157).'...';
	}else{
	$sort_description = $full_description;} 
	
	$get_ad->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}


if($seller = $mysqli->query("SELECT * FROM users WHERE id='$seller_id'")){

    $seller_row = mysqli_fetch_array($seller);
	
	$seller_name = stripslashes($seller_row['username']);

	$phone = stripslashes($seller_row['phone']);
	$show_number = stripslashes($seller_row['showno']);
	
	$seller->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

//Get Catagory

if($SelectCategories = $mysqli->query("SELECT * FROM categories WHERE id='$ad_cat_id'")){

 	$categoryRow = mysqli_fetch_array($SelectCategories);
	
	$cat_name = stripslashes($categoryRow['cname']);
		
 	$SelectCategories->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

//Get subcatagories

if($ad_subcat_id>0){
	
if($selected_subs = $mysqli->query("SELECT * FROM categories WHERE id='$ad_subcat_id'")){

 	$s_sub_row = mysqli_fetch_array($selected_subs);
	
	$subcat_name = stripslashes($s_sub_row['cname']);
		
 	$selected_subs->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

}
?>


<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo $full_title;?></h4>
           </div>
           <div class="modal-body">

<!--Data-->

      <?php if(!empty($feat_image)){?>
      <img class="img-responsive"  src="thumbs.php?src=http://<?php echo $SiteLink;?>/uploads/<?php echo $feat_image;?>&amp;w=600&amp;q=100" 
      alt="<?php echo $full_title;?>">
      <?php }?>   

<p class="col-description"><?php echo $full_description;?></p>

<div class="col-info"><h1>&#36;<?php echo stripslashes($ad_row['price']);?></h1></div>

<div class="col-info"><strong>By:</strong> <?php echo $seller_name;?><br/> <strong>Category:</strong> <?php echo $cat_name; if($ad_subcat_id>0){ echo ", $subcat_name"; }?></div>


</div><!--col-center-items-->

<!--Data-->
</div>
   <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
          <!-- /.modal-content -->
