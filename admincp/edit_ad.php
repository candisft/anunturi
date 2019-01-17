<?php include("header.php");?>

<section class="col-md-2">

<?php include("left_menu.php");?>
                    
</section><!--col-md-2-->

<section class="col-md-10">

<ol class="breadcrumb">
  <li>Admin CP</li>
  <li>Product Listings</li>
  <li>Products</li>
  <li class="active">Edit Products</li>
</ol>

<div class="page-header">
  <h3>Edit Products <small>Edit/update products</small></h3>
</div>

<script src="js/bootstrap-filestyle.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script>

$(document).ready(function(){

    $('#inputCategory').on("change",function () {
        var categoryId = $(this).find('option:selected').val();
        $.ajax({
            url: "get_subcategory.php",
            type: "POST",
            data: "categoryId="+categoryId,
            success: function (response) {
                console.log(response);
                $("#inputSubcat").html(response);
            },
        });
    }); 

});

$(document).ready(function()
{
    $('#from-ad').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div class="alert alert-info">Updating. Please wait...</div>');
		
        $(this).ajaxSubmit({
        target: '#output',
        success:  afterSuccess //call function after success
        });
    });
});
 
function afterSuccess()
{
    $('#submitButton').removeAttr('disabled'); //enable submit button

}

$(function(){

$(":file").filestyle({iconName: "glyphicon-picture", buttonText: "Select Photo"});

});

</script>

<section class="col-md-8">

<div class="panel panel-default">

    <div class="panel-body">
    
<?php

$id = $mysqli->escape_string($_GET['id']);	
	
//Get ad info

if($get_ad = $mysqli->query("SELECT * FROM ads WHERE id='$id'")){

    $ad_row = mysqli_fetch_array($get_ad);
	
	$ad_title       = stripslashes($ad_row['title']);
	$seller_id 		= stripslashes($ad_row['uid']);
	$ad_type 		= stripslashes($ad_row['type']);
	$ad_cat_id		= stripslashes($ad_row['category']);
	$ad_subcat_id	= stripslashes($ad_row['subcategory']);


	
	$get_ad->close();
	
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
	$subcat_url  = preg_replace("![^a-z0-9]+!i", "-", $subcat_name);
	$subcat_url  = urlencode(strtolower($subcat_url));
		
 	$selected_subs->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

}
	
	
?>   

<div id="output"></div>

<form action="update_ad.php?id=<?php echo $id;?>" class="forms" id="from-ad" method="post" enctype="multipart/form-data">
<div class="form-group">
                    <select class="form-control" id="inputCategory" name="inputCategory">
                    <option value="<?php echo $ad_subcat_id;?>"><?php echo $cat_name;?></option>
                      <option value="">Change Category</option>
                      <?php
if($SelectCategories = $mysqli->query("SELECT * FROM categories WHERE parent_id=0 and id!='$ad_subcat_id'")){

    while($categoryRow = mysqli_fetch_array($SelectCategories)){
				
?>
                      <option value="<?php echo $categoryRow['id'];?>"><?php echo $categoryRow['cname'];?></option>
                      <?php

}

	$SelectCategories->close();
	
}else{
    
	 printf("There Seems to be an issue");
}

?>
                    </select>
</div>

<div class="form-group">
                    <select class="form-control" id="inputSubcat" name="inputSubcat">
                    <?php if($ad_subcat_id>0){?>
                      <option value="<?php echo $ad_subcat_id;?>"><?php echo $subcat_name;?></option>
                    <?php }?>  
                      <option value="">Change Subcategory</option>
                    </select>
</div>

<div class="form-group">    
    <input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="Title" value="<?php echo $ad_title;?>" />
</div>

<div class="form-group">
                 <input type="file" name="inputImage" id="inputImage" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Add Photo">
</div>

<div class="form-group">   
   <textarea class="form-control" name="inputDescription" id="inputDescription" rows="9" placeholder="Description" ><?php echo stripslashes($ad_row['description']);?></textarea>
</div>

<div class="form-group">       
    <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="Price Ex: 100" value="<?php echo stripslashes($ad_row['price']);?>" />
</div>

<div class="form-group">
<select class="form-control" id="inputAdtype" name="inputAdtype">
<?php if($ad_type==1){?>
                <option value="1">For Sale</option>
				<option value="2">Wanted</option>
<?php }else if($ad_type==2){?>
				<option value="2">Wanted</option>
                <option value="1">For Sale</option>
<?php }?>                
            </select>
</div>

</div><!-- panel body -->

<div class="panel-footer clearfix">

<button type="submit" id="submitButton" class="btn btn-default btn-success btn-lg pull-right">Update Ad</button>

</div><!--panel-footer clearfix-->

</form>


</div><!--panel panel-default-->  

</section>

</section><!--col-md-10-->

<?php include("footer.php");?>