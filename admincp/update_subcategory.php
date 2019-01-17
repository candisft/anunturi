<?php
session_start();

include('../db.php');

if($_POST)
{	

	$id = $mysqli->escape_string($_GET['id']);
	
	if(!isset($_POST['inputCategory']) || strlen($_POST['inputCategory'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger">Please select a parent category.</div>');
	}
		
	if(!isset($_POST['inputTitle']) || strlen($_POST['inputTitle'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger">Please enter desired category.</div>');
	}
	
	if(!isset($_POST['inputDescription']) || strlen($_POST['inputDescription'])<1)
	{
		//required variables are empty
		die('<div class="alert alert-danger">Please enter description for your new category.</div>');
	}
	
	
	$ParentCategory			= $mysqli->escape_string($_POST['inputCategory']);	
	$CategoryTitle			= $mysqli->escape_string($_POST['inputTitle']);	
	$CategoryDescription	= $mysqli->escape_string($_POST['inputDescription']);
	
	
	$mysqli->query("UPDATE categories SET cname='$CategoryTitle', cat_description='$CategoryDescription', parent_id='$ParentCategory' WHERE id='$id'");
	
	
		die('<div class="alert alert-success" role="alert">Subcategory updated successfully.</div>');

		
   }else{
   	
		die('<div class="alert alert-danger" role="alert">There seems to be a problem. please try again.</div>');
  
}


?>