<?php 

session_start();

include("db.php");

//Get Site Settings

if($site_settings = $mysqli->query("SELECT * FROM settings WHERE id='1'")){

    $settings = mysqli_fetch_array($site_settings);
	
	$site_link = $settings['siteurl'];
	
	$site_title = $settings['name'];
	
	$site_template = $settings['template'];
	
	$site_settings->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

//User Info

if(isset($_SESSION['username'])){
	
$get_username = $_SESSION['username'];

if($logged_user = $mysqli->query("SELECT * FROM users WHERE username='$get_username'")){

    $logged_user_data = mysqli_fetch_array($logged_user);

	$Uid = $logged_user_data['id'];

    $logged_user->close();
	
}else{
     
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
	 
}

}

//Get catagories


error_reporting(E_ALL ^ E_NOTICE);

$id = $mysqli->escape_string($_GET['id']);
$cid = $mysqli->escape_string($_GET['cid']);
$name = $mysqli->escape_string($_GET['name']);

if($s_cat = $mysqli->query("SELECT * FROM categories WHERE id='$cid'")){

    $s_cat_row = mysqli_fetch_array($s_cat);
	
	$s_cat_name = $s_cat_row['cname'];
	$s_cat_id   = $s_cat_row['id'];
	$s_cat_url  = preg_replace("![^a-z0-9]+!i", "-", $s_cat_name);
	$s_cat_url  = urlencode(strtolower($s_cat_url));
	
	$s_cat_description   = $s_cat_row['cat_description'];
	
	$s_cat->close();
	
}else{
    
	 printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

//Ads

if($AdsSql = $mysqli->query("SELECT * FROM siteads WHERE id='1'")){

    $AdsRow = mysqli_fetch_array($AdsSql);
	
	$Ad1 = stripslashes($AdsRow['ad1']);
	$Ad2 = stripslashes($AdsRow['ad2']);
	$Ad3 = stripslashes($AdsRow['ad3']);
	
    $AdsSql->close();

}else{
	
     printf("<div class='alert alert-danger alert-pull'>There seems to be an issue. Please Trey again</div>");
}

$mysqli->query("UPDATE settings SET hits=hits+1 WHERE id=1");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $s_cat_name;?> | <?php echo $site_title;?></title>
<meta name="description" content="<?php echo $s_cat_description;?>" />
<meta name="keywords" content="<?php echo $settings['keywords'];?>" />

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="favicon.ico" rel="shortcut icon" type="image/x-icon"/>

<!--Facebook Meta Tags-->
<meta property="fb:app_id"          content="<?php echo $settings['fb_app_id']; ?>" /> 
<meta property="og:url"             content="http://<?php echo $site_link; ?>/cat-recent-<?php echo $s_cat_id;?>-<?php echo $s_cat_url;?>-1.html" /> 
<meta property="og:title"           content="<?php echo $site_title;?>" />
<meta property="og:description" 	content="<?php echo $s_cat_description;?>" /> 
<meta property="og:image"           content="http://<?php echo $site_link; ?>/images/logo.png" /> 
<!--End Facebook Meta Tags-->


<link href="templates/<?php echo $site_template;?>/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="templates/<?php echo $site_template;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="templates/<?php echo $site_template;?>/css/style.css" rel="stylesheet" type="text/css">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="js/jquery.min.js"></script>	
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.timeago.js"></script>
<script>
jQuery(document).ready(function() {
  jQuery("abbr.timeago").timeago();
});
</script>
</head>

<body>

<div id="wrap">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://<?php echo $site_link;?>"><img src="images/logo.png" class="logo" alt="<?php echo $site_title;?>"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
              <?php
		

$menu_categories = array();

$menu_sql = "SELECT id, cname, parent_id FROM categories ORDER BY cname";
$menu_res = $mysqli->query($menu_sql);
while ($menu_row = mysqli_fetch_assoc($menu_res)) {

	
    $parent = intval($menu_row['parent_id']);
    if (!isset($menu_categories[$parent])) {
        $menu_categories[$parent] = array();
    }
    $menu_categories[$parent][] = $menu_row;
}


function build_categories($parent, $menu_categories) {
    if (isset($menu_categories[$parent]) && count($menu_categories[$parent])) {
      
	 
		 foreach ($menu_categories[$parent] as $get_mcat) {
			 
			 $menu_cat_name = $get_mcat['cname'];
			 $menu_cat_link = preg_replace("![^a-z0-9]+!i", "-", $menu_cat_name);
		     $menu_cat_link = urlencode($menu_cat_link);
		     $menu_cat_link = strtolower($menu_cat_link);
			 			 
			 if($get_mcat['parent_id']==0){
			  echo '<li><a href="cat-recent-'.$get_mcat['id'].'-'.$menu_cat_link.'-1.html">' .$get_mcat['cname'].'</a>';
			 }else{
			  echo '<li><a href="sub-recent-'.$get_mcat['id'].'-'.$menu_cat_link.'-1.html"><span class="fa fa-chevron-circle-right"></span> '.$get_mcat['cname'].'</a>';		 
			 }
            echo build_categories($get_mcat['id'], $menu_categories);
			echo '</li>';
        }
		

	}
   
}				
				
?>

<li class="dropdown nav-mobile-only">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">			

<?php $menu = build_categories(0, $menu_categories);?>			

</ul>
</li>
      </ul>
      <ul class="nav navbar-nav navbar-right">  
      <?php if(!isset($_SESSION['username'])){?>      
        <li><a href="login.html"><i class="fa fa-user navbar-icon"></i> Intra in Cont</a></li>
        <?php  }else{ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user navbar-icon"></i>  Cont <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li><a href="my_ads-recent-1.html">Anunturi</a></li>
            <li><a href="favorites-recent-1.html">Favorite</a></li>
            <li><a href="settings.html">Setari</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.html">Iesire</a></li>
          </ul>          
        </li>
        <?php }?>
 		<li><a href="post.html">Adauga Anunt</a></li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
   </div><!-- /.container -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid container-search">
  <div class="container">

<form role="search" method="get" action="search.php">
         
         <div class="form-group">
           <div class="col-md-5">
           <div class="row col-small">
         <div class="input-group"> <span class="input-group-addon"><span class="fa fa-search"></span></span>  
         <input type="text" class="form-control form-small-2" id="term" name="term" placeholder="Cauta"> 
         </div>
           </div><!--row-->
           </div><!--col-md-5-->
         
            <div class="col-md-3" style="width:190px">
            <div class="row col-small">
            <div class="input-group"> <span class="input-group-addon"><span class="fa fa-info"></span></span>
            <select class="form-control" id="type" name="type">
              <option value="all">Toata Romania</option>
           <?php
if($jud = $mysqli->query("SELECT * FROM jud WHERE active=1 ORDER BY jname ASC")){

  while ($judrow = mysqli_fetch_array($jud)){
    $judname = stripslashes($judrow['jname']);
    
?>
    <option value="<?php echo stripslashes($judrow['id']);?>"><?php echo $judname;?></option>
<?php     
  }
$jud->close();
}else{
     printf("<div class='alert alert-danger alert-pull'>Se pare ca e o eroare, mai incearca</div>");
}
?>
            </select>
            </div>

            </div><!--row-->
             </div><!--col-md-3-->


         <div class="col-md-4">
         <div class="row col-small">
         <div class="input-group"> <span class="input-group-addon"><span class="fa fa-list"></span></span>
           <select class="form-control" id="cat" name="cat">
                    <option value="all">Toate categoriile</option>
           <?php
if($search_categories = $mysqli->query("SELECT * FROM categories WHERE parent_id=0 ORDER BY cname ASC")){

  while ($search_catrow = mysqli_fetch_array($search_categories)){
    $search_catname = stripslashes($search_catrow['cname']);
    
?>
    <option value="<?php echo stripslashes($search_catrow['id']);?>"><?php echo $search_catname;?></option>
<?php     
  }
$search_categories->close();
}else{
     printf("<div class='alert alert-danger alert-pull'>Se pare ca e o eroare, mai incearca</div>");
}
?>
           
            </select>
            </div>  
            </div><!--row-->    
            </div><!--col-md-4-->

            <div class="col-btn">
            <input type="hidden" class="input" id="id" name="id" value="recent"/> 
            <button type="submit" class="btn btn-custom btn-width"><i class="btn-search glyphicon glyphicon-search"></i> <span class="btn-mobile-only">Search</span></button>
            </div>
         </div>       
       </form>

 </div><!-- /.container -->
</div><!-- /.container-fluid -->