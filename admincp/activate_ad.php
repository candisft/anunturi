<?php

include("../db.php");

$id = $mysqli->escape_string($_POST['id']);

$update = $mysqli->query("UPDATE ads SET active='1' WHERE id='$id'");

echo '<div class="alert alert-success" role="alert">Ad activated successfully.</div>';

?>