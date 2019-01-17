<?php

include("../db.php");

$id = $mysqli->escape_string($_POST['id']);

$mysqli->query("UPDATE ads SET active='0', feat='0' WHERE id='$id'");


echo '<div class="alert alert-success" role="alert">Ad updated successfully.</div>';

?>