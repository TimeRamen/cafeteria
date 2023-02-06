
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.1.1/dist/chart.umd.js" integrity="sha256-l5LW9aB/BWnxagS2D7wr3hmEIn9r0avEf/OosPYOUZM=" crossorigin="anonymous"></script>
<style>
    .navbar > .container, .navbar > .container-fluid, .navbar > .container-lg, .navbar > .container-md, .navbar > .container-sm, .navbar > .container-xl, .navbar > .container-xxl {
  display: block;
}
</style>



<?php include('partials-front/menu.php');
?>

<div class="container">
    <h1>Order History</h1>
    <h3>Today is <?php echo date("Y-m-d");?></h3>
    <?php if($_SESSION['type_id']==4){?>
    <button onclick='ClearAllUnpaid()'>Clear Unpaid Orders</button>
    <?php }?>
    <input id=unpaid type=checkbox onclick='renderUnpaid()'>Only Show Unpaid Orders</input>
    <div class="accordion" id="accordion">
        <?php
        
            $c_id = $_SESSION['id'];
            $type = $_SESSION['type_id'];
            $sql = $type==4?returnAllOrders():returnOrders($c_id);
            $res=mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            
            if($count>0)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    $order_id = $row['order_id'];
                    $total = $row['total'];
                    $pickup = $row['pickup'];
                    $customer = $row['c_id'];
                    $room = $row['room'];
                    $flag = strtotime(strtok($pickup," ")) > strtotime('now');
                    $paid = $row['paid'];

                    $sellerFlag = $type==4;
                    $sql2 = returnOrderItems($order_id);
                    $res2 = mysqli_query($conn, $sql2);
                    $aItem = "Order ".$order_id." ( ".$pickup." )";

                    if($sellerFlag){
                        $username = $row['username'];
                        $aItem = $username." order ".$order_id." ( ".$pickup." )  ";
                        if($paid==0){
                            $aItem .="<a class='btn btn-primary' onclick='markAsPaid($order_id)'>Mark as Paid</a>";
                        }else{
                            $aItem .=" <em>Paid</em>";
                        }
                        
                    }

                    if($flag){
                        $aItem .= "<a class='btn btn-danger' onclick='removeOrder($order_id)'>Remove Preorder</a>";
                    }

                    renderAccordionItem(
                        "acc".strval($order_id),
                        "col".strval($order_id),
                        $aItem,
                        renderOrderItems($res2,$total,$room,$flag)
                    );
                }
            
        ?>
    </div>
                        <?php
            }else
                {
                    echo "<div class='error'>There have been no orders.</div>";
                }

?>
<h2><?php echo $type==4?"Revenue":"Expenditure";?> History for <input type=number value='<?php echo date("Y");?>' onchange='renderExpenditure(this.value)'></input></h2>
<?php
    $sql = $type==4?sqlReturnExpenditure():sqlReturnExpenditureUser($c_id);
    $res=mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    echo "<div id='expenditure'>";
    if($count>0)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    $month = $row['month'];
                    $monthName = DateTime::createFromFormat('!m', intval($month))->format('F');
                    $total = $row['total'];
                    echo "<p>$monthName : BDT $total.00</p>";
                }
    echo "</div>";
                
//echo "<canvas id='expense' style='width:100%;max-width:700px'></canvas>";



            }else
                {
                    echo "<div class='error'>There have been no expenses this year.</div>";
                }









?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="js\jquery-3.6.3.min.js"></script>
    <script src="js\alertify\alertify.min.js"></script>
    <script src="js\cart.js"></script>
    
    
    <?php
    
    
    ?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="js\jquery-3.6.3.min.js"></script>
    <script src="js\alertify\alertify.min.js"></script>
    <script src="js\order.js"></script>