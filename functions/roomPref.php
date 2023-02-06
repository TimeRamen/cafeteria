<?php
include('../config/constants.php');
$room = $_GET['room'] == ""?null:$_GET['room'] ;
$c_id = $_SESSION['id'];
runMasterRoomQuery($conn,$c_id,$room);
?>