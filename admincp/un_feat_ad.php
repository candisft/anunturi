<?php

include("../db.php");

$id = $mysqli->escape_string($_POST['id']);

$update = $mysqli->query("UPDATE ads SET feat='0' WHERE id='$id'");

echo '<div class="alert alert-success" role="alert">Ad updated successfully.</div>';

?>