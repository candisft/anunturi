<?php include("header.php");?>



<div class="container container-pull">

<?php

if($categories = $mysqli->query("SELECT `id`,`cname`, cat_image, (SELECT COUNT(`category`) FROM `ads` a WHERE a.active =1 AND a.category = c.id) as ad_count FROM `categories` c WHERE c.parent_id = 0 ORDER BY `cname` ASC")){

  while ($cat_row = mysqli_fetch_array($categories)){
		$cat_name = stripslashes($cat_row['cname']);
		$cat_url  = preg_replace("![^a-z0-9]+!i", "-", $cat_name);
		$cat_url  = urlencode(strtolower($cat_url));
		
		$cat_icon = stripslashes($cat_row['cat_image']);
		
		if(!empty($cat_icon)){
			
			$show_icon = "http://".$site_link."/icons/".$cat_icon;
			
		}else{
			
			$show_icon = "http://".$site_link."/templates/".$site_template."/images/cat_default.png";
			
		}
		
		
?>
<div class="col-sm-8 col-xs-12 col-md-3 col-lg-3" style="height:50px;">

<a href="cat-recent-<?php echo stripslashes($cat_row['id']);?>-<?php echo $cat_url;?>-1.html">
<img src="thumbs.php?src=<?php echo $show_icon;?>&amp;h=32&amp;w=32&amp;q=100" alt="<?php echo $cat_name;?>">
<?php echo $cat_name;?></a> (<?php echo $cat_row['ad_count'];?>)

</div><!-- /.col-box -->

<?php     
	}
$categories->close();
}else{
     printf("<div class='alert alert-danger alert-pull'>E o eroare, mai incearca!</div>");
}
?>


</div><!-- /.container --> 


<div class="container col-center">

</div><!-- /.container -->

<?php if(!empty($Ad1)){?>

<div class="ad-block-2"><?php echo $Ad1;?></div>

<?php }?>
 

<?php include("footer.php");?>