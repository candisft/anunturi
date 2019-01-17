<?php include("header.php");?>

<section class="col-md-2">

<?php include("left_menu.php");?>
                    
</section><!--col-md-2-->

<section class="col-md-10">

<ol class="breadcrumb">
  <li>Admin CP</li>
  <li class="active">Dashboard</li>
</ol>

<div class="page-header">
  <h3>Dashboard <small>Your website dashboard</small></h3>
</div>

<section class="col-md-8">

<section class="col-md-6 box-space-right">

<div class="panel panel-default">

<div class="panel-heading"><h4>Ad Statistics</h4></div>

    <div class="panel-body">

<ul>

<?php
if($total_ads = $mysqli->query("SELECT id FROM ads")){

    $count_ads = $total_ads->num_rows;
  
?> 
     <li class="fa fa-file-text-o"><span>Total Ads: <?php echo $count_ads;?></span></li>

<?php

    $total_ads->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

if($active_ads= $mysqli->query("SELECT id FROM ads WHERE active=1")){

    $count_active = $active_ads->num_rows;
?>     

	<li class="fa fa-file-text-o"><span>Total Active Ads: <?php echo $count_active;?></span></li>

<?php

    $active_ads->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

if($pending_ads = $mysqli->query("SELECT id FROM ads WHERE active=0")){

    $count_pending = $pending_ads->num_rows;
?>      
    <li class="fa fa-file-text-o"><span>Total Pending Ads <?php echo $count_pending;?></span></li>
<?php

    $pending_ads->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

?> 
</ul>

</div>

</div><!--panel panel-default-->  

</section><!--col-md-6-->

<section class="col-md-6">

<div class="panel panel-default">

<div class="panel-heading"><h4>Site Statistics</h4></div>

    <div class="panel-body">

<ul>

     
    <li class="fa fa-bar-chart-o"><span>Total Site Views: <?php echo $Settings['hits'];?></span></li>
<?php

if($ad_views = $mysqli->query("SELECT SUM(views) AS VIEWS FROM ads")){

    $count_view = mysqli_fetch_array($ad_views);
?>

<li class="fa fa-bar-chart-o"><span>Total Ad Views: <?php echo $count_view['VIEWS'];?></span></li> 

<?php


    $ad_views->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

if($total_users = $mysqli->query("SELECT id FROM users")){

    $count_users = $total_users->num_rows;
 
?>    
    <li class="fa fa-users"><span>Total Registed Users: <?php echo $count_users;?></span></li>

<?php

    $total_users->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

?>

</ul>

</div>

</div><!--panel panel-default--> 

</section><!--col-md-6-->
</section><!--col-md-8-->

<section class="col-md-8 box-space-top">

<div class="panel panel-default">

<div class="panel-heading"><h4>Last 10 Active Ads</h4></div>

    <div class="panel-body">

<?php

$display_approved= $mysqli->query("SELECT * FROM ads WHERE active='1' ORDER BY id DESC LIMIT 10");

	$number_of_actives = $display_approved->num_rows;
	
	if ($number_of_actives==0)
	{
	echo '<div class="alert alert-danger">There are no approved ads to display at this moment.</div>';
	}
	if ($number_of_actives>0)
	{
	?>
       <table class="table table-bordered">

        <thead>

            <tr>
				<th>Thumb</th>
                
                <th>Title</th>

                <th>Added On</th>
                
            </tr>

        </thead>

        <tbody>
    <?php
	}
	
	while($app_row = mysqli_fetch_assoc($display_approved)){
	
	$app_long_title = stripslashes($app_row['title']);
	$crop_title = strlen ($app_long_title);
	if ($crop_title > 200) {
	$sort_app_title = substr($app_long_title,0,200).'...';
	}else{
	$sort_app_title = $app_long_title;}
	
	$feat_image = stripslashes($app_row['image']);

?>        

            <tr>
				<td><a data-toggle="modal" href="preview.php?id=<?php echo $app_row['id'];?>" data-target="#adModal">
                
                <?php if(!empty($feat_image)){?>
      <img class="media-object" src="thumbs.php?src=http://<?php echo $SiteLink;?>/uploads/<?php echo $feat_image;?>&amp;h=64&amp;w=64&amp;q=100" 
      alt="<?php echo $app_long_title;?>">
   <?php }else{?> 
   <img class="media-object" src="thumbs.php?src=http://<?php echo $SiteLink;?>/templates/<?php echo $site_template;?>/images/no_img.png&amp;h=64&amp;w=64&amp;q=100" 
      alt="<?php echo $app_long_title;?>">
   <?php }?>     
                </a></td>
                
                <td><a data-toggle="modal" href="preview.php?id=<?php echo $app_row['id'];?>" data-target="#adModal"><?php echo ucfirst($sort_app_title);?></a></td>


                <td><abbr class="timeago" title="<?php echo $app_row['date'];?>"></abbr></td>

            </tr>
<?php } ?>
    
         
        </tbody>

    </table>
    

</div>

</div><!--panel panel-default--> 

</section><!--col-md-8-->


<section class="col-md-8 box-space-top">

<div class="panel panel-default">

<div class="panel-heading"><h4>Last 10 Pending Ads</h4></div>

    <div class="panel-body">

<?php

$display_pending= $mysqli->query("SELECT * FROM ads WHERE active=0 ORDER BY id DESC LIMIT 10");

	$number_of_pending = $display_pending->num_rows;
	
	if ($number_of_pending==0)
	{
	echo '<div class="alert alert-danger">There are no approval pending posts to display at this moment.</div>';
	}
	if ($number_of_pending>0)
	{
	?>
       <table class="table table-bordered">

        <thead>

            <tr>
				<th>Thumb</th>
                
                <th>Title</th>

                <th>Added On</th>
                
            </tr>

        </thead>

        <tbody>
    <?php
	}
	
	while($pend_row = mysqli_fetch_assoc($display_pending)){
	
	$pending_title = stripslashes($pend_row['title']);
	$crop_pending_title = strlen ($pending_title);
	if ($crop_pending_title > 200) {
	$sort_pending_title = substr($pending_title,0,200).'...';
	}else{
	$sort_pending_title = $pending_title;}
	
	$feat_pen_image = stripslashes($pend_row['image']);
?>        

            <tr>
				<td> <a data-toggle="modal" href="preview.php?id=<?php echo $pend_row['id'];?>" data-target="#adModal"><?php if(!empty($feat_pen_image)){?>
      <img class="media-object" src="thumbs.php?src=http://<?php echo $SiteLink;?>/uploads/<?php echo $feat_pen_image;?>&amp;h=64&amp;w=64&amp;q=100" 
      alt="<?php echo $pending_title;?>">
   <?php }else{?> 
   <img class="media-object" src="thumbs.php?src=http://<?php echo $SiteLink;?>/templates/<?php echo $site_template;?>/images/no_img.png&amp;h=64&amp;w=64&amp;q=100" 
      alt="<?php echo $pending_title;?>">
   <?php }?> </a>    </td>
                
                <td><a data-toggle="modal" href="preview.php?id=<?php echo $pend_row['id'];?>" data-target="#adModal"><?php echo ucfirst($sort_pending_title);?></a></td>

                <td><abbr class="timeago" title="<?php echo $pend_row['date'];?>"></abbr></td>

            </tr>
<?php } ?>
    
         
        </tbody>

    </table>
    

</div>

</div><!--panel panel-default--> 

<!--Product Modal-->
<div class="modal fade" id="adModal" tabindex="-1" role="dialog" aria-labelledby="adModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
   
   
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});
</script>

</section><!--col-md-8-->

</section><!--col-md-10-->

<?php include("footer.php");?>