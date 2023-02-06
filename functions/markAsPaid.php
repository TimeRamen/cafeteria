<?php
include('../config/constants.php');
$order_id = $_GET['id'];
markAsPaid($conn, $order_id);
?>