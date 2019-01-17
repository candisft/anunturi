<?php include("header.php");?>

<?php if(!isset($_SESSION['username'])){?>
<script>
function leave() {
  window.location = "login.html";
}
setTimeout("leave()");
</script>

<?php }else{

$show_phone = $logged_user_data['showno'];	
	
	
?>

<div class="container container-main">

<div class="container-pages col-rounded">

<div class="col-md-8">

<h1 class="page-title">Setari</h1>

<div id="output"></div>

  <form action="update_settings.php?id=<?php echo $Uid;?>" id="from-settngs" method="post" >
<div class="form-group">
    <input type="text" disabled class="form-control" name="inputName" id="inputName" placeholder="Name" value="<?php echo $logged_user_data['username'];?>" />
</div>
<div class="form-group">    
    <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email address" value="<?php echo $logged_user_data['email'];?>" />
</div>

<div class="form-group">
<div class="row">
<div class="col-md-6">       
    <input type="text"class="form-control" name="inputPhone" id="inputPhone" placeholder="Phone No (Optional)" value="<?php echo $logged_user_data['phone'];?>" />
</div>   
<div class="col-md-6">
<?php if($show_phone==1){?>    
	<label class="checkbox-inline"><input type="checkbox" name="inputShowNmber" id="inputShowNmber">Ascunde numar</label>
<?php }else if($show_phone==2){?>  
<label class="checkbox-inline"><input type="checkbox" checked name="inputShowNmber" id="inputShowNmber">Ascunde numar</label>
<?php }?>   
</div>
</div>
</div>

<div class="form-group">       
    <input type="text" class="form-control" name="inputState" id="inputState" placeholder="State/Province" value="<?php echo $logged_user_data['location'];?>" />
</div>
     
    <button type="submit" class="btn btn-custom pull-right" id="submitButton">Modifica</button>

</form>

<div class="col-pull-bottom">

<h1 class="page-title">Parola</h1>

<div id="output-pass"></div>

<form action="update_password.php" id="form-password" method="post" >

<div class="form-group">
    <label for="nPassword">Parola curenta</label>
    <input type="password" class="form-control" name="nPassword" id="uPassword" placeholder="scrie parola curenta" />
</div><!--/ form-group -->
<div class="form-group">    
     <label for="uPassword">Parola noua</label>
    <input type="password" class="form-control" name="uPassword" id="uPassword" placeholder="scrie noua parola" />
</div><!--/ form-group -->
<div class="form-group">    
     <label for="cPassword">Confirma parola</label>
    <input type="password" class="form-control" name="cPassword" id="cPassword" placeholder="scrie inca o data parola" />
</div><!--/ form-group -->
    
  <button type="submit" class="btn btn-custom pull-right" id="submitButton">Modifica</button>
  

</form>

</div>

</div><!-- /.col-md-8-->

<div class="col-md-4">

<div class="col-tips">
<?php if(!empty($Ad3)){?>
<div class="ad-block_right">
<?php echo $Ad3;?>
</div>
<?php }?>

</div><!--col-tips-->


</div><!-- /.col-md-4-->

</div><!-- /.container-pages col-rounded -->

</div><!-- /.container container-main -->


<?php if(!empty($Ad1)){?>

<div class="ad-block-2"><?php echo $Ad1;?></div>

<?php }?>
 
<script src="js/jquery.form.js"></script>

<script>
$(document).ready(function()
{
    $('#from-settngs').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div class="alert alert-info">Submiting... Please wait...</div>');
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

$(document).ready(function()
{
    $('#form-password').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output-pass").html('<div class="alert alert-info">Submiting... Please wait...</div>');
        $(this).ajaxSubmit({
        target: '#output-pass',
        success:  afterSuccess //call function after success
        });
    });
});
 
function afterSuccess()
{
    $('#submitButton').removeAttr('disabled'); //enable submit button
}
</script>

<?php } include("footer.php");?>