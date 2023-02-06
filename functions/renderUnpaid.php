<?php
  include('../config/constants.php');
  /*
  $search = $_GET['search'] == ""?null:$_GET['search'] ;
  $dietString = $_GET['diet'];
  $budget = $_GET['budget']==""?null:strval($_GET['budget']);
  $category = $_GET['category']==0?null:$_GET['category'];
  $sort = $_GET['sort']==0?null:$_GET['sort'];
  */
  
  

            $c_id = $_SESSION['id'];
            $type = $_SESSION['type_id'];


            $sql = $type==4?returnUnpaidOrders():returnUnpaidOrdersCustomer($c_id);
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
            }
        ?>