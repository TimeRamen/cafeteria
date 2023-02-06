<?php

include 'config/constants.php';

if ($_SESSION['type_id'] ==3) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/admin2.css">
    <!-- <link rel="stylesheet" type="text/css" href="admin.css"> -->

    <style media="screen">
        div{
            display: block;
        }
        #admin_name{
            color: black;
        }
        .main-content{
            background-color: #f1f2f6;
            padding: 3% 0;
            height: 250px;
        }
        .wrapper2{
            padding: 1%;
            width: 80%;
            margin: 0 auto;
        }
        .col-4{
            width: 18%;
            background-color: #ff6b81;
            margin: 1%;
            padding: 2%;
            float: left;
        }
        .text-center{
            text-align: center;
        }
        table{
            border:1px solid black;
            /* border-collapse:  collapse; */
            width: 500px;
        }
        th{
            border: 1px solid black;
            font-size: 15px;
            padding: 6px;
        }
        td{
            border: 1px solid black;
            text-align: center;
        }

    </style>
</head>
<body>
<div class="menu text-center">
        <div class="wrapper">
        <ul>
                <li>
                    <a href="admin_home.php">Home</a>
                </li>
                <li>
                    <a href="admin/admin_to_customer.php">Customer</a>
                </li>
                <li>
                    <a href="admin/admin_to_seller.php">Salesman</a>
                </li>
                <li>
                    <a href="admin/admin_to_category.php">Category</a>
                </li>
                <li>
                    <a href="admin/admin_to_items.php">Food Items</a>
                </li>
                <li>
                    <a href="functions/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>

   <div class="main-content">
    
   <h1 id="admin_name">Hello, <?php echo $_SESSION['name']; ?></h1>
    <div class="wrapper2">
        <br><br><br>
        <div class="col-4 text-center">
            <?php
            $sql = "SELECT dietary.id as num FROM dietary ORDER BY id DESC LIMIT 1";
            $query = mysqli_query($conn, $sql);
            $category = mysqli_fetch_array($query);
            ?>
            <h1><?php echo ($category['num']) ?></h1>
            <br>
            Categories
        </div>
        <div class="col-4 text-center">
            <?php
            $sql1 ="SELECT food_items.id as num_food_item FROM food_items ORDER BY id DESC LIMIT 1";
            $query1 = mysqli_query($conn, $sql1);
            $tot_item = mysqli_fetch_array($query1);
            ?>
            <h1><?php echo($tot_item['num_food_item']) ?></h1>
            <br>
            Foods
        </div>
        <div class="col-4 text-center">
            <?php
            $sql2 = "SELECT count(id) AS total FROM orders";
            $query2 = mysqli_query($conn, $sql2);
            $value = mysqli_fetch_assoc($query2);
            ?>
            <h1><?php echo($value['total']) ?></h1>
            <br>
            Total Orders
            <br>
            
        </div>
        <div class="col-4 text-center">
            <h1><?php
            $sql3 = sqlReturnYearlyRevenue(date('Y')); 
            $query3 = mysqli_query($conn, $sql3);
            $value = mysqli_fetch_assoc($query3);
            $total = $value['total'];
            echo "BDT $total";?></h1>
            <br>
            Total Revenue for <?php echo date('Y');?>
        </div>
    </div>
    
    <button onclick='clearGuests()'>Clear All Guests</button>
   
</div>
   
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="js\jquery-3.6.3.min.js"></script>
    <script src="js\alertify\alertify.min.js"></script>
<script src="js\admin.js">
    </script>
</html>
<?php
}
else{
    header("Location: index.php");
    exit();
}