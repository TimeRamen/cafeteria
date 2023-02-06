<?php
include('../config/constants.php');
$g_id = $_SESSION['id'];
$problemItem = itemExceedingQuantityInCart($conn,$g_id);
if($problemItem!=0){//qty < stock)
    echo "Item $problemItem exceeds current stock.";
}else{
    //stock -= qty;
    //echo "Order placed";
    reduceStockByQuantity($conn,$g_id);
    //startOrder($conn,$room,$pickup,$c_id);
    $o_id = guestOrder($conn,$g_id);
    echo "<h1>Order $o_id has been placed.<h1>
<h3>Please pick your order up from the cafeteria.</h3>";
$_SESSION['id'] = generateRandomGuest($conn);
}



?>