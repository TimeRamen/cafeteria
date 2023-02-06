<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Food Order System</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">

<!-- CSS -->
<link rel="stylesheet" href="js/alertify/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="js/alertify/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="js/alertify/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="js/alertify/css/themes/bootstrap.min.css"/>
<!--Font Awesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    


    <style type="text/css">
	
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    #qty{
        width: 50px;
        text-align: center
    }
    input[type="number"] {
        -moz-appearance: textfield;
        appearance: textfield;
    }

    .btn-minus,.btn-plus{
        cursor:pointer;
        -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    }

    
</style>



</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <?php
                
                if(isset($_SESSION['name'])){
                    $name = $_SESSION['name'];
                    $id = $_SESSION['id'];
                    echo "Hello, $name : $id";
                }
                ?>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Home <!--img src="./../icons/house-solid.svg"/--></a>
                    </li>
                    <?php if($_SESSION['type_id']!=5){ ?>
                    <li>
                        <a href="<?php echo SITEURL; ?>orders.php">Orders <!--img src="./../icons/house-solid.svg"/--></a>
                    </li>
                    <?php }?>
                    <li>
                        <a href="<?php echo SITEURL; ?>cart.php">Cart <!--img src="./../icons/cart-shopping-solid.svg"  /--></a>
                    </li>
                    <?php

                    /*

                    <form action="login.php" method="post">
        
        <h2>Login</h2>
        <?php if (isset($_GET['error'])){ ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php }?>

        <label style="color: black;">Username</label>
        <input type="text" name="username" placeholder="Username"><br>
        <label style="color: black;">Password</label>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit">Log in</button>
        <a style="float: left; margin-left: 13px;" href='customers/index.php'>Back</a> 

    </form>
<!--href="login.php"-->
                     */

                    if($_SESSION['type_id']==5){
                        ?>
                            <li>
                                <form action="functions/login.php" method="post">
                                <?php if (isset($_GET['error'])){ ?>
                                    <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php }?>
                                    <input type="text" name="username" placeholder="Username">
                                    <input type="password" name="password" placeholder="Password">
                                    <button type='submit'>Login</button>
                                </form>
                            </li>
                            <li>
                                <a href="registration.php">Registration</a>
                            </li>
                                <?php
                    }else{
                        ?>
                    <li>
                        <a href="functions/logout.php">Logout</a>
                    </li>
                        <?php
                    }
                    ?>
                   
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->
