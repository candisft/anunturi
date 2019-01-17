<?php include("header.php");?>

<?php if(!isset($_SESSION['username'])){?>
<script>
function leave() {
  window.location = "login.html";
}
setTimeout("leave()");
</script>

<?php }else{
	
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
    
	 printf("<div class='alert alert-danger alert-pull'>E o eroare, mai incearca</div>");
}

//Get Catagory

if($SelectCategories = $mysqli->query("SELECT * FROM categories WHERE id='$ad_cat_id'")){

 	$categoryRow = mysqli_fetch_array($SelectCategories);
	
	$cat_name = stripslashes($categoryRow['cname']);


 	$SelectCategories->close();
	
}else{
    
	 printf("Se pare ca e o eroare");
}


if($Selectjud = $mysqli->query("SELECT * FROM jud WHERE id='$ad_type'")){

    $judRow = mysqli_fetch_array($Selectjud);
    
    $jud_name = stripslashes($judRow['jname']);


    $Selectjud->close();
    
}else{
    
     printf("Se pare ca e o eroare");
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
    
	 printf("Se pare ca e o eroare");
}

}
	
	
?>

 

<div class="container container-main">

<div class="container-pages col-rounded">

<div class="col-md-8">

<h1 class="page-title">Modifica anuntul</h1>

<?php if($seller_id==$Uid){ ?>

<div id="output"></div>

<form action="update_ad.php?id=<?php echo $id;?>" class="forms" id="from-ad" method="post" enctype="multipart/form-data">
<div class="form-group">
                    <select class="form-control" id="inputCategory" name="inputCategory">
                    <option value="<?php echo $ad_subcat_id;?>"><?php echo $cat_name;?></option>
                      <option value="">Schimba categoria</option>
                      <?php
if($SelectCategories = $mysqli->query("SELECT * FROM categories WHERE parent_id=0 and id!='$ad_subcat_id'")){

    while($categoryRow = mysqli_fetch_array($SelectCategories)){
				
?>
                      <option value="<?php echo $categoryRow['id'];?>"><?php echo $categoryRow['cname'];?></option>
                      <?php

}

	$SelectCategories->close();
	
}else{
    
	 printf("Se pare ca e o eroare");
}

?>
                    </select>
</div>

<div class="form-group">
                    <select class="form-control" id="inputSubcat" name="inputSubcat">
                    <?php if($ad_subcat_id>0){?>
                      <option value="<?php echo $ad_subcat_id;?>"><?php echo $subcat_name;?></option>
                    <?php }?>  
                      <option value="">Schimba subcategoria</option>
                    </select>
</div>

<div class="form-group">    
    <input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="Titlu" value="<?php echo $ad_title;?>" />
</div>

<div class="form-group">
                 <input type="file" name="inputImage" id="inputImage" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Adauga Poza">
</div>

<div class="form-group">   
   <textarea class="form-control" name="inputDescription" id="inputDescription" rows="9" placeholder="Descriere" ><?php echo stripslashes($ad_row['description']);?></textarea>
</div>

<div class="form-group">       
    <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="Pret Ex: 100" value="<?php echo stripslashes($ad_row['price']);?>" />
</div>

<div class="form-group">
<select class="form-control" id="inputAdtype" name="inputAdtype">
                    <option value="<?php echo $ad_type;?>"><?php echo $jud_name;?></option>
                      <option value="">Schimba Localitatea</option>
                      <?php
if($Selectjud = $mysqli->query("SELECT * FROM jud WHERE active=1 and id!='$ad_type'")){

    while($judRow = mysqli_fetch_array($Selectjud)){
                
?>
                      <option value="<?php echo $judRow['id'];?>"><?php echo $judRow['jname'];?></option>
                      <?php

}

    $Selectjud->close();
    
}else{
    
     printf("Se pare ca e o eroare");
}

?>              
            </select>
</div>
     
<button type="submit" class="btn btn-custom pull-right" id="submitButton">Modifica</button>


</form>

<?php }else{?>

<div class="alert alert-danger">Nu ai drepturi sa modifici acest anunt. Acest anunt apartine altui utilizator.</div>

<?php }?>

</div><!-- /.col-md-8-->

<div class="col-md-4">

</div><!-- /.col-md-4-->

</div><!-- /.container-pages col-rounded -->

</div><!-- /.container container-main -->
 
<script src="js/jquery.form.js"></script>
<script src="js/bootstrap-filestyle.min.js"></script>
 
<script>

$(document).ready(function(){

    $('#inputCategory').on("change",function () {
        var categoryId = $(this).find('option:selected').val();
        $.ajax({
            url: "update_subcategory.php",
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
 

<?php } include("footer.php");?>