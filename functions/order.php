<?php
include('../config/constants.php');
$room = $_GET['room'] == ""?null:$_GET['room'] ;
$pickup = $_GET['pickup']==""?null:$_GET['pickup'];
$c_id = $_SESSION['id'];

$problemItem = itemExceedingQuantityInCart($conn,$c_id);
if(date('Y-m-d') == date('Y-m-d',strtotime($pickup))){
    if($problemItem!=0){//qty < stock)
        echo "Item $problemItem exceeds current stock.";
    }else{
        //stock -= qty;
        echo "Order placed";
        reduceStockByQuantity($conn,$c_id);
        startOrder($conn,$room,$pickup,$c_id);
    }
}else{
    echo "Order placed";
    startOrder($conn,$room,$pickup,$c_id);
}



?>