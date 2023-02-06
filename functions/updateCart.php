<?php
include('../config/constants.php');
$food_id = $_GET['id'];
$qty = $_GET['qty'];
$c_id = $_SESSION['id'];
$sql = sqlUpdateCartQty($food_id,$c_id,$qty);
mysqli_query($conn,$sql);
?>