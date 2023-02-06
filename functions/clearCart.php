<?php
include('../config/constants.php');
$c_id = $_SESSION['id'];
$sql = sqlEmptyCart($c_id);
mysqli_query($conn,$sql) or die("cannot run");
?>