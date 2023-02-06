<?php  
include '../config/constants.php';

if(isset($_GET['id'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}


	$id = validate($_GET['id']);
    $sql_dt = "DELETE FROM food_diet WHERE food_id='$id' ";
    $res = mysqli_query($conn, $sql_dt);


	$sql = "DELETE FROM food_items WHERE id='$id'";
    $result = mysqli_query($conn, $sql);


    if ($result) {
        echo "<script>alert('Record Deleted from Database')</script>";
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT ="0; URL=
        http://localhost/cafeteria/admin/admin_to_items.php">
        <?php

        //header("Location: admin_to_items.php?success=successfully deleted");
    }

}
else {
	header("Location: ../admin_home.php");
}
?>
