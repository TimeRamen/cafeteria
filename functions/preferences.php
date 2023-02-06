<?php
include('../config/constants.php');
$dietString = $_GET['diet'];
$diet = json_decode($dietString);
$budget = $_GET['budget']==""?null:strval($_GET['budget']);
$c_id = $_SESSION['id'];
runMasterPreferenceQuery($conn,$c_id,$budget,$diet);

?>