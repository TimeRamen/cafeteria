<?php
include('../config/constants.php');
$id = $_GET["id"];
$c_id = $_SESSION['id'];
$sql = sqlDeleteFromCart($id,$c_id);
mysqli_query($conn,$sql) or die("cannot run");
?>