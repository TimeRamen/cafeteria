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
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../css/admin2.css">
    <style media="screen">
          table{
            border:1px solid black;
            /* border-collapse:  collapse; */
            width: 650px;
            margin-left: 30px;
            margin-top: 30px;
        }
        th{
            border: 1px solid black;
            font-size: 15px;
            padding: 6px;
            
        }
        td{
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-size: 19px;

        }
        #del{
        
            color: black;
            background-color: red;  
        }
        .scroller {
        background-color: #ff6b81;
        width: 700px;
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
    <h1 style="color: black;">Seller Data</h1>
    <br>
    <div class="scroller">
    <table>
        <th>ID</th>
        <th>Name</th>
        <th>User_Type</th>
        <th>Action</th>
        <?php

    $sql = "SELECT user.id,user.name,user_type.name as Customer_Type FROM user inner join user_type on user.type_id=user_type.id WHERE user.type_id = 4";
    $query = mysqli_query($conn, $sql);

    while ($info = mysqli_fetch_array($query)) {
        ?>
                <tr>
                    <td><?php echo $info['id'] ?></td>
                    <td><?php echo $info['name'] ?></td>
                    <td><?php echo $info['Customer_Type'] ?></td>
                    <td style="align-items: center; justify-content: center; display: flex"><a id="del" onclick="return checkdelete()" href="delete.php?id=<?= $info['id'] ?>" class ="btn btn-danger">Delete</a></td>

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
    <!-- </a> -->
    <a href="../admin_home.php" id="c_see">Back</a>
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