<?php
    include '../config/constants.php';
    error_reporting(0);
    session_start();
if ($_SESSION['type_id'] == 3) {

    $up_sql = "SELECT food_items.id as num from food_items ORDER BY id DESC LIMIT 1";
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
            <td>Name </td>
            <td><input type="text"  name="name" required></td>
        </tr>
        <tr>
            <td>Price </td>
            <td><input type="text"  name="price" required></td>
        </tr>
        <tr>
            <td>Stock </td>
            <td><input type="text"  name="stock" required></td>
        </tr>
        <tr>
            <td>Food Type  </td>
            <td>
            <?php
    $sql_type_of_food = "SELECT id,food_type FROM food_type";
    $query_type_of_food = mysqli_query($conn, $sql_type_of_food);
            ?>
                      <select name="type_of_food" >
                        <?php
    while ($data_type_of_food = mysqli_fetch_assoc($query_type_of_food)) {
                        ?>
                            <option style="color: black;" value= <?php echo $data_type_of_food['id'] ?>><?php echo $data_type_of_food['food_type'] ?></option>
                        <?php
    }
                        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Allergen </td>
            <td>
            <?php
    $sql_type_of_diet = "SELECT id,diet FROM dietary";
    $query_type_of_diet = mysqli_query($conn, $sql_type_of_diet);
    while ($data_type_of_diet = mysqli_fetch_assoc($query_type_of_diet)) {
            ?>
                <input type="checkbox" name="diet_type[]" value=<?php echo $data_type_of_diet['id'] ?>><label><?php echo $data_type_of_diet['diet'] ?></label>
                    <?php
    }

                    ?>

            </td>
        </tr>
        <!-- <tr>
            <td colspan="10"id="food_adding"><a href="admin_to_items.php" id="add_food_items">Back </a>
            <input type="submit" id="button" name="submit" value="Submit"></td>
        </tr> -->
        </form>
    </table>
    <br>
    <div id="food_adding">

        <a href="admin_to_items.php" id="back_in">Back </a>
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
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $Food_Type = $_POST['type_of_food'];
        $u = $_POST['diet_type'];
        // echo ($u);
        $sql2 = "INSERT INTO `food_items`(`id`, `name`, `price`, `stock`, `food_type_id`) VALUES ('$h','$name','$price','$stock','$Food_Type')";
        $data = mysqli_query($conn, $sql2);

        foreach ($u as $it) {
            $qu = "INSERT INTO food_diet (food_id,diet_id) VALUES ('$h','$it')";
            $qu_run = mysqli_query($conn, $qu);
        }

        if ($data) {
            header("Location: admin_to_items.php");
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