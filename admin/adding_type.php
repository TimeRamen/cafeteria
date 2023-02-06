<?php
    include '../config/constants.php';
    error_reporting(0);
session_start();
if ($_SESSION['type_id'] == 3) {

    $up_sql = "SELECT dietary.id as num from dietary ORDER BY id DESC LIMIT 1";
    $add = mysqli_query($conn, $up_sql);
    $has = mysqli_fetch_array($add);
    $h = $has['num'] + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Food</title>
    <link rel="stylesheet" type="text/css" href="../css/style2.css">
    
</head>
<body>
    
<br>
    <h1 style="color: black;">New Food</h1>
    <form action="" method="POST">
    <table>
        <tr>
            <td>ID </td>
            <td><input type="text"  name="id"  value="<?php echo ($h) ?>" readonly></td>
        </tr>
        <tr>
            <td>Diet Type </td>
            <td><input type="text"  name="name" required></td>
        </tr>
        <br>
        <tr>
            <td>Polarity</td>
            <td>
            <select name="polarity" >
                <option value="1">Free</option>
                <option value="2">Friendly</option>
            </select>
            </td>
        </tr>
        </form>

    </table>

    <br>
    <div id="food_adding">

        <a href="admin_to_category.php" id="back_in">Back </a>
        <input type="submit" id="button" name="submit" value="Submit">

    </div>
    
   
</body>
</html>

</body>
</html>

<?php

    if (isset($_POST['submit'])) {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $polarity = $_POST['polarity'];

        // echo ($u);
        $sql2 = "INSERT INTO dietary VALUES ('$h','$name','$polarity')";
        $data = mysqli_query($conn, $sql2);

        
        if ($data) {
            header("Location: admin_to_category.php");
        } else {
            echo "Failed to update";
        }

    }
}
else{
    header("Location: ../index.php");
    exit();
}

?>