<?php include("header.php");?>

<?php if(isset($_SESSION['username'])){?>
<script>
function leave() {
  window.location = "index.html";
}
setTimeout("leave()");
</script>

<?php }else{?>

 

<div class="container container-main">

<div class="container-small">

<h1 class="page-title">Creeaza o parola noua</h1>

<p>Introdu email-ul cu care ai creat contul. Vei primi un email cu datele pentru a te conecta.</p>

<div id="output"></div>


<form id="recoveredForm" action="send_recovery.php" method="post">

<div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon">@</span>
<input type="email" class="form-control" name="inputRecovery" id="inputRecovery" placeholder="Email-ul cu care te-ai inregistrat">
</div>
</div>
   
<button type="submit" id="submitButton" class="btn btn-custom pull-right">Reseteaza</button>

</form>


</div><!-- /.container-pages col-rounded -->

<?php if(!empty($Ad1)){?>

<div class="ad-block-2"><?php echo $Ad1;?></div>

<?php }?>

</div><!-- /.container container-main -->
 
<script src="js/jquery.form.js"></script>

<script>
$(document).ready(function()
{
    $('#recoveredForm').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div class="alert alert-info" role="alert">Working.. Please wait..</div>');
		
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
 

<?php } include("footer.php");?>