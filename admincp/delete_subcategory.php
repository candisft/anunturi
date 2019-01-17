<?php

include("../db.php");

$del = $mysqli->escape_string($_POST['id']);

//Delete Catagories

$mysqli->query("DELETE FROM categories WHERE id='$del'");

echo '<div class="alert alert-success" role="alert">Category successfully deleted</div>';

?>