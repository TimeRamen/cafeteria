<?php
include('../config/constants.php');
//$c_id = $_SESSION['id'];
$order_id = $_GET['id'];
sqlRemoveOrder($conn, $order_id);
//mysqli_query($conn,$sql) or die("cannot run");
?>