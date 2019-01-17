<?php include("header.php");?>

<section class="col-md-2">

<?php include("left_menu.php");?>
                    
</section><!--col-md-2-->

<section class="col-md-10">

<ol class="breadcrumb">
  <li>Admin CP</li>
  <li>Settings</li>
  <li class="active">Home Page Settings</li>
</ol>

<div class="page-header">
  <h3>Home Page Settings <small>Update your website home page settings</small></h3>
</div>

<script src="js/bootstrap-filestyle.min.js"></script>
<script>
$(function(){
$(":file").filestyle({iconName: "glyphicon-picture", buttonText: "Select Photo"});
});
</script>

<script type="text/javascript" src="js/jquery.form.js"></script>

<script>
$(document).ready(function()
{
    $('#settingsForm').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div class="alert alert-info" role="alert">Submitting.. Please wait..</div>');
		
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
</script>

<section class="col-md-8">

<div class="panel panel-default">

    <div class="panel-body">


<?php 

if($SiteSettings = $mysqli->query("SELECT * FROM settings WHERE id='1'")){

    $SettingsRow = mysqli_fetch_array($SiteSettings);
	
    $SiteSettings->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}


?>

<div id="output"></div>

<form id="settingsForm" action="update_home_page.php" enctype="multipart/form-data" method="post">


<div class="form-group">
<label for="inputfile">Home Promo Image (2000px x 600px)</label>
<input type="file" id="inputfile" name="inputfile" class="filestyle" data-iconName="glyphicon-picture" data-buttonText="Select Promo Image">
</div>

<div class="form-group">
        <label for="inputLineOne">Home Page Promo Title</label>
    <div class="input-group">
         <span class="input-group-addon"><span class="glyphicon fa  fa-info"></span></span>
      <input type="text" id="inputLineOne" name="inputLineOne" class="form-control" placeholder="Enter your promo title here" value="<?php echo $SettingsRow['htitle']?>">
    </div>
</div>

<div class="form-group">
        <label for="inputLineTwo">Home Page Promo Description</label>
    <div class="input-group">
         <span class="input-group-addon"><span class="glyphicon fa  fa-info"></span></span>
      <input type="text" id="inputLineTwo" name="inputLineTwo" class="form-control" placeholder="Enter your promo description here" value="<?php echo $SettingsRow['hdisc']?>">
    </div>
</div>

</div><!-- panel body -->

<div class="panel-footer clearfix">

<button type="submit" id="submitButton" class="btn btn-default btn-success btn-lg pull-right">Update Home Page Settings</button>

</div><!--panel-footer clearfix-->

</form>


</div><!--panel panel-default-->  

</section>

</section><!--col-md-10-->

<?php include("footer.php");?>