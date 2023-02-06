<?php  

include "../config/constants.php";

if(isset($_GET['id'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}


	$id = validate($_GET['id']);
    $type = "SELECT * FROM user WHERE user.id = '$id'"  ;
    $res = mysqli_query($conn,$type);
    if(mysqli_num_rows($res) === 1){
        $row = mysqli_fetch_assoc($res);

    }
	$sql = "DELETE FROM user
	        WHERE id='$id' ";
    $result = mysqli_query($conn, $sql);

   if ($row['type_id'] == 4 ){
        if ($result) {
            echo "<script>alert('Record Deleted from Database')</script>";
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT ="0; URL=
            http://localhost/cafeteria/admin/admin_to_seller.php">
            <?php
           // header("Location: admin_to_seller.php?success=successfully deleted");
        }

    }
    else{
        
        echo "<script>alert('Record Deleted from Database')</script>";
                    
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT ="0; URL=
        http://localhost/cafeteria/admin/admin_to_customer.php">
        <?php

        //header("Location: admin_to_customer.php?success=successfully deleted");

     }

   

}
else {
	header("Location: ../admin_home.php");
}