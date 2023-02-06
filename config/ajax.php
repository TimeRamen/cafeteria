<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();


if($action == "add_to_cart"){
	$save = $crud->add_to_cart();
	if($save)
		echo $save;
}
ob_end_flush();
?>
