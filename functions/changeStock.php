<?php
include('../config/constants.php');
$food_id = $_GET['id'];
$stock = $_GET['stock'];
$sql = sqlUpdateStock($food_id,$stock);
mysqli_query($conn,$sql);
?>