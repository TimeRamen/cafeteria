<?php
include '../config/constants.php';
if ($_SESSION['type_id'] == 3) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <link rel="stylesheet" type="text/css" href="../css/admin2.css">
    <style media="screen">
        table{
            border:1px solid black;
            /* border-collapse:  collapse; */
            width: fit-content;

        }
        th{
            border: 1px solid black;
            font-size: 15px;
        }
        td{
            border: 1px solid black;
            text-align: center;
            font-size: 19px;

        }
        #del{
            color: black;
            background-color: red; 
        }
        #up{
            color: black;
            background-color: green;        }
        .scroller {
        background-color: #ff6b81;
        width: 680px;
        height: 600px;
        overflow-y: scroll;
        scrollbar-color: rebeccapurple green;
        scrollbar-width: thin;
        }
      
    </style>
</head>
<body>
<div class="menu text-center">
        <div class="wrapper">
        <ul>
                <li>
                    <a href="../admin_home.php">Home</a>
                </li>
                <li>
                    <a href="admin_to_customer.php">Customer</a>
                </li>
                <li>
                    <a href="admin_to_seller.php">Salesman</a>
                </li>
                <li>
                    <a href="admin_to_category.php">Diet</a>
                </li>
                <li>
                    <a href="admin_to_items.php">Food Items</a>
                </li>
                <li>
                    <a href="../functions/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="old">
    <h1 style="color: black">Food Items</h1>
    <br>
    <div class="scroller">
    <table>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>

        <th>Food Type</th>
        <th>Actions</th>
        <?php

    $sql1 = "SELECT food_items.id,food_items.name,food_items.price,food_items.stock,food_type.food_type as Food_Type FROM food_items INNER JOIN food_type on food_items.food_type_id = food_type.id ORDER by food_items.id";
    $query1 = mysqli_query($conn, $sql1);

    while ($info = mysqli_fetch_array($query1)) {
        ?>
                <tr>
                    <td><?php echo $info['id'] ?></td>
                    <td><?php echo $info['name'] ?></td>
                    <td><?php echo $info['price'] ?></td>
                    <td><?php echo $info['stock'] ?></td>
                    <td><?php echo $info['Food_Type'] ?></td>
                    <td><a id="up" href="update.php?rn=<?= $info['id'] ?>&fn=<?= $info['name'] ?>&ln=<?= $info['price'] ?>&em=<?= $info['Food_Type'] ?>&kn=<?= $info['stock'] ?>">Update</a>
                        <a id="del" onclick="return checkdelete()" href="item_delete.php?id=<?= $info['id'] ?>" class ="btn btn-danger">Delete</a></td>

                </tr>

                <?php

    }
                ?>

    </table>
    </div>
    <script>
                function checkdelete()
                {
                    return confirm('Are you sure you want to Delete this Record');
                }
    </script>
    <br>
      <div id="add_item">
        <a href="adding_food.php" id="item">Add Items</a>
        <a href="../admin_home.php" id="back_page">Back</a>
        <br><br>

    </div>
    </div>

  
</body>

</html>
<?php
}
else{
    header("Location: ../index.php");
    exit();
}
?>
