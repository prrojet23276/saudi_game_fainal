<?php
require "db.php";

$id = $_POST['id'];
$x = $_POST['x'];
$y = $_POST['y'];

mysqli_query($conn,"UPDATE cities SET x_position='$x', y_position='$y' WHERE city_id='$id'");
?>