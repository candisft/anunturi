<?php include("header.php");?>

<?php if(!isset($_SESSION['username'])){?>
<script>
function leave() {
  window.location = "login.html";
}
setTimeout("leave()");
</script>

<?php }else{?>

 

<div class="container container-main">

<div class="container-pages col-rounded">

<div class="col-md-8">

<h1 class="page-title">Posteaza anuntul</h1>

<div id="output"></div>

<form action="submit_ad.php" class="forms" id="from-ad" method="post" enctype="multipart/form-data">
<div class="form-group">
                    <select class="form-control" id="inputCategory" name="inputCategory">
                      <option value="">Alege o categorie</option>
                      <?php
if($SelectCategories = $mysqli->query("SELECT * FROM categories WHERE parent_id=0")){

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
                      <option value="">Alege o subcategorie</option>
                    </select>
</div>

<div class="form-group">    
    <input type="text" class="form-control" name="inputTitle" id="inputTitle" placeholder="Titlu" />
</div>

<div class="form-group">
                 <input type="file" name="inputImage" id="inputImage" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Adauga imagine 1"><br />
                 <input type="file" name="inputImage2" id="inputImage2" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Adauga imagine 2"><br />
                 <input type="file" name="inputImage3" id="inputImage3" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Adauga imagine 3"><br />
</div>

<div class="form-group">   
   <textarea class="form-control" name="inputDescription" id="inputDescription" rows="9" placeholder="Descriere" ></textarea>
</div>

<div class="form-group">       
    <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="Pret in lei" />
</div>

<div class="form-group">
<select class="form-control" id="inputAdtype" name="inputAdtype">
                      <option value="">Alege Localitatea</option>
                      <?php
if($Selectjud = $mysqli->query("SELECT * FROM jud WHERE active=1")){

    while($judRow = mysqli_fetch_array($Selectjud)){
        
?>
                      <option value="<?php echo $judRow['id'];?>"><?php echo $judRow['jname'];?></option>
                      <?php

}

  $Selectjud->close();
  
}else{
    
   printf("There Seems to be an issue");
}

?>
            </select>
</div>
     
<button type="submit" class="btn btn-custom pull-right" id="submitButton">Posteaza anunt</button>


</form>

</div><!-- /.col-md-8-->

<div class="col-md-4">

<div class="col-tips">

<span class="fa fa-lightbulb-o"></span>

<div class="text-tip"><h4><span class="text-s">Sfat:</span> Adauga poze reale!</h4>
<p>Adaugand poze reale vei avea mai multe sanse de a-ti vinde produsul mai repede.</p>

</div>

</div><!--col-tips-->

<div class="col-tips">
<?php if(!empty($Ad3)){?>
<div class="ad-block_right">
<?php echo $Ad3;?>
</div>
<?php }?>

</div><!--col-tips-->

</div><!-- /.col-md-4-->

</div><!-- /.container-pages col-rounded -->

<?php if(!empty($Ad1)){?>

<div class="ad-block-2"><?php echo $Ad1;?></div>

<?php }?>

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
        $("#output").html('<div class="alert alert-info">Posting. Please wait...</div>');
		
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