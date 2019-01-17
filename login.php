<?php include("header.php");?>

<div class="container container-main">

<div class="container-pages col-rounded">

<?php if(!isset($_SESSION['username'])){?>


<div class="col-md-6">

 <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#sectionA">Intra in Cont</a></li>
        <li><a data-toggle="tab" href="#sectionB">Creeaza un Cont</a></li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
            
           <div id="output-login">&nbsp;</div>
            
				<form role="form" action="submit_login.php" id="form-login" method="post">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" name="username" id="username" placeholder="Cont">
							<label for="username" class="input-group-addon glyphicon glyphicon-user"></label>
						</div>
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" name="password" id="password" placeholder="Parola">
							<label for="password" class="input-group-addon glyphicon glyphicon-lock"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

					<div class="checkbox">
						<a href="recover.html">Ai uitat parola?</a>
					</div> <!-- /.checkbox -->		
			
				<button class="form-control btn btn-custom" id="submitButton">Intra in Cont</button> 
           
   </form>
   </div>
<div id="sectionB" class="tab-pane fade">

<div id="output"></div>

           <form action="submit_user.php" id="from-register" method="post" >
<div class="form-group">
    <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Nume" />
</div>
<div class="form-group">    
    <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email" />
</div>

<div class="form-group">
<div class="row">
<div class="col-md-6">       
    <input type="text"class="form-control" name="inputPhone" id="inputPhone" placeholder="Optional numar telefon" />
</div>   
<div class="col-md-6">    
	<label class="checkbox-inline"><input type="checkbox" name="inputShowNmber" id="inputShowNmber">Ascunde telefon</label>
</div>
</div>
</div>

<div class="form-group">       
    <input type="text" class="form-control" name="inputState" id="inputState" placeholder="Judetul" />
</div>

<div class="form-group">       
    <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Parola" />
</div>
<div class="form-group">       
    <input type="password" class="form-control" name="inputcPassword" id="inputcPassword" placeholder="Conform Parola" />
</div>

<div class="checkbox">
	Prin inregistrare esti deacord cu <a href="tos.html">Termeni si Conditiile</a>
</div> <!-- /.checkbox -->
     
    <button type="submit" class="form-control btn btn-custom" id="submitButton">Inregistare</button>

</form>
        </div>
</div>
</div><!-- /.col-md-6 -->

<?php }else{?>

<div class="alert alert-danger" role="alert">Esti deja inregistrat si in cont.</div>


<?php }?>

</div><!-- /.container-pages col-rounded -->


<?php if(!empty($Ad1)){?>

<div class="ad-block-2"><?php echo $Ad1;?></div>

<?php }?>

</div><!-- /.container container-main -->

<script src="js/jquery.form.js"></script>

<script>
$(document).ready(function()
{
    $('#form-login').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output-login").html('<div class="alert alert-info">Log in you on. Please wait...</div>');
		
        $(this).ajaxSubmit({
        target: '#output-login',
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
    $('#from-register').on('submit', function(e)
    {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div class="alert alert-info">Working. Please wait...</div>'); 
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
 

<?php include("footer.php");?>