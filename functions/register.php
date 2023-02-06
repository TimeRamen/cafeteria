<?php
session_start(); 

include "connet_with_db.php";

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])&& isset($_POST['c_password']) ){
    // echo "OK";
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
    $uname = validate($_POST['username']);
	$pass = validate($_POST['password']);
    $c_pass= validate($_POST['c_password']);
    $customer_typ = $_POST['type'];
    $name = $_POST['name'];

    if(empty($_POST['name'])){
        header("Location: registration.php?error=Name is required");
	    exit();
    }
     else if(empty($_POST['email'])){
        header("Location: registration.php?error=Email is required");
	    exit();
     }
    
    else if(empty($customer_typ)){
        header("Location: registration.php?error=Type is required");
	    exit();
    }
    else if (empty($uname)) {
		header("Location: registration.php?error=User Name is required");
	    exit();
	}
    
    else if(empty($pass)){
        header("Location: registration.php?error=Password is required");
	    exit();
	}
    else if($pass !== $c_pass){
        header("Location: registration.php?error=Password is not same");
	    exit();
    }
    else if(strpos($_POST['email'],".uiu.ac.bd") == false){
        header("Location: registration.php?error=Outsider");
        exit();
    }
   else {
    $sql = "SELECT * FROM user WHERE id='$uname'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) !== 0) {
        header("Location: registration.php?error=Accout alraedy exist");
	    exit();
    }
    else{
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql1 = "INSERT INTO user VALUE ('$uname','$name','$hash','$customer_typ')";
            $result1 = mysqli_query($conn, $sql1);
            session_unset();
            session_destroy();
            header("Location:index.php");

    }    
   }

}
else{
    header("Location:registration.php");
    exit();
}

