<?php
include('../config/constants.php');
$stock = $_GET['stock'];
$sql = sqlUpdateAllStock($stock);
mysqli_query($conn,$sql);
?>