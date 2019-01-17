<?php

include("../db.php");


$id = $mysqli->escape_string($_GET['id']);

if($user = $mysqli->query("SELECT * FROM users WHERE id='$id'")){

    $user_info = mysqli_fetch_array($user);
	
	$user->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}


if($tot_ads = $mysqli->query("SELECT uid FROM ads WHERE uid='$id'")){

    $ad_count = $tot_ads->num_rows;
	
	$tot_ads->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}
?>


<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo stripslashes(ucfirst($user_info['username']));?></h4>
           </div>
           <div class="modal-body">
<!--Data-->

<div class="info-row"><strong>Username:</strong> <?php echo stripslashes(ucfirst($user_info['username']));?></div>
<div class="info-row"><strong>Registed Date:</strong> <?php echo stripslashes(ucfirst($user_info['date']));?></div>

<div class="info-row"><strong>Total Ads:</strong> <?php echo $ad_count;?></div>

<div class="ad-info"> <span class="contact-icons fa fa-phone-square"></span>
          <div class="contact-p label-telephone"><?php echo stripslashes(ucfirst($user_info['phone']));?></div>
        </div>
        <!-- /.ad-info --> 

        <div class="ad-info"> <span class="contact-icons fa fa-envelope"></span>
          <div class="contact-p"><?php echo stripslashes(ucfirst($user_info['email']));?></div>
        </div>
        <!-- /.ad-info --> 

<!--Data-->
</div>
   <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
          <!-- /.modal-content -->
