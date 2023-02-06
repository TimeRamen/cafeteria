<?php
include('../config/constants.php');
$year = $_GET["year"];
$type = $_SESSION['type_id'];
$c_id = $_SESSION['id'];

$sql = $type==4?sqlReturnExpenditure($year):sqlReturnExpenditureUser($c_id,$year);
    $res=mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count>0)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    $month = $row['month'];
                    $monthName = DateTime::createFromFormat('!m', intval($month))->format('F');
                    $total = $row['total'];
                    echo "<p>$monthName : BDT $total.00</p>";
                }
            }
                ?>