<?php
//session_start(); 

//include "connet_with_db.php";
include('../config/constants.php');

if(isset($_POST['username']) && isset($_POST['password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
    $uname = validate($_POST['username']);
	$pass = validate($_POST['password']);

    $sql1 = "SELECT id FROM user_type WHERE name like 'Student'";
    $res1=mysqli_query($conn, $sql1);
    $data1 = mysqli_fetch_assoc($res1);

    $sql2 = "SELECT id FROM user_type WHERE name like 'Faculty'";
    $res2=mysqli_query($conn, $sql2);
    $data2 = mysqli_fetch_assoc($res2);

    $sql3 = "SELECT id FROM user_type WHERE name like 'Admin'";
    $res3=mysqli_query($conn, $sql3);
    $data3 = mysqli_fetch_assoc($res3);

    $sql4 = "SELECT id FROM user_type WHERE name like 'Seller'";
    $res4=mysqli_query($conn, $sql4);
    $data4 = mysqli_fetch_assoc($res4);

    if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}
    else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}
    else {

         $sql = "SELECT * FROM user WHERE id='$uname' ";

		$result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($pass,$row['password'])) {
            	$_SESSION['id'] = $row['id'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['type_id'] = $row['type_id'];
                if($row['type_id'] === $data1['id'] or $row['type_id'] === $data2['id']){
                    header("Location: ../index.php");
		            exit();
                }
                if($row['type_id'] === $data3['id']){
                    header("Location: ../admin_home.php");
		            exit();
                }
                if($row['type_id'] === $data4['id']){
                    header("Location: ../index.php");//seller_home.php");
		            exit();
                }
            	
            }else{
                header("Location: index.php?error=Incorrect Username or Password");
                exit();
            }
        }
        else{
            header("Location: index.php?error=Incorrect Username or Password");
            exit();
        }
    }


}
else{
    header("Location:index.php");
    exit();
}

