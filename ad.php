<?php include("header_ads.php");

if($seller = $mysqli->query("SELECT * FROM users WHERE id='$seller_id'")){

    $seller_row = mysqli_fetch_array($seller);
	
	$seller_name = stripslashes($seller_row['username']);
	$seller_link = preg_replace("![^a-z0-9]+!i", "-", $seller_name);
	$seller_link = urlencode($seller_link);
	$seller_link = strtolower($seller_link);
	
	$phone = stripslashes($seller_row['phone']);
	$show_number = stripslashes($seller_row['showno']);

	$seller->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>E o eroare</div>");
}

//Get Catagory

if($SelectCategories = $mysqli->query("SELECT * FROM categories WHERE id='$ad_cat_id'")){

 	$categoryRow = mysqli_fetch_array($SelectCategories);
	
	$cat_name = stripslashes($categoryRow['cname']);
	$cat_url  = preg_replace("![^a-z0-9]+!i", "-", $cat_name);
	$cat_url  = urlencode(strtolower($cat_url));
		
 	$SelectCategories->close();
	
}else{
    
	 printf("E o eroare");
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
    
	 printf("E o eroare");
}

}

$originalDate = stripslashes($ad_row['date']);
$newDate = date("F j, Y, g:i a", strtotime($originalDate));

?>
  <div class="container container-main">
    <div class="container-pages col-rounded">
      <div class="col-md-8">
        <h1 class="post-title"><?php echo stripslashes($ad_row['title']);?></h1>
        <p class="post-p">Adaugat de <a data-toggle="modal" data-target="#EmailModal" href="#"><?php echo ucfirst($seller_name); ?></a> in <?php echo $newDate;?></p>
        <div class="ad-img">
          <?php if(!empty($feat_image)){?>
          <img class="img-responsive" src="thumbs.php?src=http://<?php echo $site_link;?>/uploads/<?php echo $feat_image;?>&amp;w=600&amp;q=100" 
      alt="<?php echo stripslashes($ad_row['title']);?>">
          <?php }else{?>
          <img class="img-responsive" src="thumbs.php?src=http://<?php echo $site_link;?>/templates/<?php echo $site_template;?>/images/no_img.png&amp;w=600&amp;q=100" 
      alt="<?php echo stripslashes($ad_row['title']);?>">
          <?php }?>
        </div>
        <!-- /.ad-img -->
        
        <p class="post-d"><?php echo nl2br(stripslashes($ad_row['description']));?></p>

<br /><br /><br />

          <?php if($ad_row['image2']){?>
           <img class="img-responsive" src="thumbs.php?src=http://<?php echo $site_link;?>/uploads/<?php echo $ad_row['image2'];?>&amp;w=600&amp;q=100" 
      alt="<?php echo stripslashes($ad_row['title']);?>">
          <?php }?>
<br />
           <?php if($ad_row['image3']){?>
           <img class="img-responsive" src="thumbs.php?src=http://<?php echo $site_link;?>/uploads/<?php echo $ad_row['image3'];?>&amp;w=600&amp;q=100" 
      alt="<?php echo stripslashes($ad_row['title']);?>">
          <?php }?>

      </div>
      <!-- /.col-md-8 -->
      
      <div class="col-md-4 ad-right">
        <h2>Detalii contact</h2>
        <?php if(($show_number==1)&& (!empty($phone))){?>
        <a href="#" id="btn-telephone">
        <div class="ad-info"> <span class="contact-icons fa fa-phone-square"></span>
          <div class="contact-p label-telephone">Arata telefon</div>
        </div>
        <!-- /.ad-info --> 
        </a>
        <?php }?>
        <a data-toggle="modal" data-target="#EmailModal" href="#">
        <div class="ad-info"> <span class="contact-icons fa fa-envelope"></span>
          <div class="contact-p">Trimite mesaj</div>
        </div>
        <!-- /.ad-info --> 
        </a>
        <div class="info-text">
          <h1>Pret: <?php echo $settings['currency'];?> <?php echo stripslashes($ad_row['price']);?> lei</h1>
        </div>
        <div class="other-info">
          <h4><span class="txt-strong">Locatie:</span>
            <?php echo $jud_name;?>
          </h4>
        </div>
        <div class="other-info">
          <h4><span class="txt-strong">Categorie:</span> <a href="cat-recent-<?php echo $ad_cat_id;?>-<?php echo $cat_url;?>-1.html"><?php echo $cat_name;?></a>
            <?php if($ad_subcat_id>0){?>
            , <a href="sub-recent-<?php echo $ad_subcat_id;?>-<?php echo $subcat_url;?>-1.html"><?php echo $subcat_name;?></a>
            <?php }?>
          </h4>
        </div>
         <div class="other-info">
          <h4><span class="txt-strong">Vizualizari:</span>
            <?php echo stripslashes($ad_row['views']);?>
          </h4>
        </div>
    
		<?php if(!isset($_SESSION['username'])){ ?>
        <a href="login.html">
        <div class="ad-info-2"> <span class="contact-icons fa fa-star"></span>
          <div class="contact-p">Salveaza ca favorit</div>
        </div>
        </a>        
        <?php }else{ 
		
		if($favs = $mysqli->query("SELECT user_id, ad_id FROM favorites WHERE ad_id='$id' AND user_id='$Uid'")){
	
		$count_favs = $favs->num_rows; 
	
		$favs->close();
	
		}else{
    
	 	printf("<div class='alert alert-danger alert-pull'>E o eroare</div>");
		}
		
		if ($count_favs==1){?>
        <a class="favs" data-id="<?php echo stripslashes($ad_row['id']);?>" data-name="fav" href="#">
        <div class="ad-info-2"> <span class="contact-icons fa fa-star"></span>
          <div class="contact-p">Ai salvat ca favorit</div>
        </div>
        </a>
        <?php }else {?>
        <a class="favs" data-id="<?php echo stripslashes($ad_row['id']);?>" data-name="fav" href="#">
        <div class="ad-info-2"> <span class="contact-icons fa fa-star"></span>
          <div class="contact-p">Salveaza ca favorit</div>
        </div>
        </a>
        <?php } } ?>
        <!-- /.ad-info -->
       
        
        </div>
      <!-- /.col-md-4 --> 
      
    </div>
    <!-- /.container-pages col-rounded --> 
    
  </div>
  <!-- /.container container-main -->
 
  
  <!--Email Modal-->
  <div id="EmailModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Trimite lui <?php echo ucfirst($seller_name); ?> un mesaj</h4>
        </div>
        <div class="modal-body">
          <div id="output"></div>
          <form id="contact_from" action="contact_seller.php?id=<?php echo $seller_id?>" method="post">
            <div class="form-group">
              <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input type="text" class="form-control" name="inputYourname" id="inputYourname" placeholder="Numele">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group"> <span class="input-group-addon">@</span>
                <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Adresa de email">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group"> <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                <input type="text" class="form-control" name="inputPhone" id="inputPhone" placeholder="Numar de Telefon">
              </div>
            </div>
            <div class="form-group">
              <textarea class="form-control" id="inputMessage" name="inputMessage" rows="3" placeholder="Mesaj"></textarea>
            </div>
            <button type="submit" id="submitButton" class="btn btn-custom btn-block">Trimite</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="js/jquery.form.js"></script> 
  <script>
$(document).ready(function () {
	
	$('#btn-telephone').click(function(e) {
    e.preventDefault();
    $('.label-telephone').html('<?php echo $phone;?>');
});
});
$(document).ready(function()
{
    $('#contact_from').on('submit', function(e)
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
function popup(e){var t=700;var n=400;var r=(screen.width-t)/2;var i=(screen.height-n)/2;var s="width="+t+", height="+n;s+=", top="+i+", left="+r;s+=", directories=no";s+=", location=no";s+=", menubar=no";s+=", resizable=no";s+=", scrollbars=no";s+=", status=no";s+=", toolbar=no";newwin=window.open(e,"windowname5",s);if(window.focus){newwin.focus()}return false}

$(function() {
$(".favs").click(function() 
{
var id = $(this).data("id");
var name = $(this).data("name");
var dataString = 'id='+ id ;
var parent = $(this);

if (name=='fav')
{
$(this).fadeIn(200).html;
$.ajax({
type: "POST",
url: "add_favorite.php",
data: dataString,
cache: false,

success: function(html)
{
parent.html(html);
}
});
}
return false;
});
});

</script>

<?php if(!empty($Ad1)){?>

<div class="ad-block-2"><?php echo $Ad1;?></div>

<?php }?>

<?php include("footer.php");?>