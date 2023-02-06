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
    <title>Dietary Restrictions</title>
    <link rel="stylesheet" type="text/css" href="../css/admin2.css">
    <style media="screen">
        table{
            border:1px solid black;
            /* border-collapse:  collapse; */
            width: 650px;

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
    <h1 style="color: black">Dietary Restrictions</h1>
    <br>
    <div class="scroller">
    <table>
        <th>ID</th>
        <th>Diet Type</th>
        <!-- <th>Price</th>
        <th>Food Type</th> -->
        <th>Polarity</th>
        <?php

    $sql1 = "SELECT dietary.id, dietary.diet,dietary.free from dietary";
    $query1 = mysqli_query($conn, $sql1);

    while ($info = mysqli_fetch_array($query1)) {
        if($info['free'] == 1){
                $free = 'Free';
        }
        else{
            $free = 'Friendly';
        }
        ?>
        
                <tr>
                    <td><?php echo $info['id'] ?></td>
                    <td><?php echo $info['diet'] ?></td>
                    <td><?php echo $free ?></td>
                   
                </tr>

                <?php

    }
                ?>

    </table>
    </div>

    <br>
      <div id="add_item">
        <a href="adding_type.php" id="item">Add New Type</a>
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
