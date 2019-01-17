<?php include("header.php");?>

<div class="container container-main">

<?php if(!empty($Ad1)){?>

<div class="ad-block-1"><?php echo $Ad1;?></div>

<?php }?>

<div class="container-pages col-rounded">

<h1 class="page-title">Terms of Use</h1>

 <?php
if($get_pages = $mysqli->query("SELECT * FROM  pages WHERE id='3'")){

    $page_content = mysqli_fetch_array($get_pages);
	
?>           
            <p class="note"><?php echo $page_content['page'];?></p>

<?php	

    $get_pages->close();
	
}else{
    
	 printf("There Seems to be an issue");
}
?> 

</div><!-- /.container-pages col-rounded -->

</div><!-- /.container container-main -->


<?php include("footer.php");?>