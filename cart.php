
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<style>
    .navbar > .container, .navbar > .container-fluid, .navbar > .container-lg, .navbar > .container-md, .navbar > .container-sm, .navbar > .container-xl, .navbar > .container-xxl {
  display: block;
}
</style>
<?php include('partials-front/menu.php');
//if(isset($_SESSION['id']) && isset($_SESSION['name'])){


?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="js\jquery-3.6.3.min.js"></script>
    <script src="js\alertify\alertify.min.js"></script>
    <script src="js\cart.js"></script>
<div class="container">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Item</th>
      <th scope="col">Quantity</th>
      <th scope="col">Subtotal</th>
    </tr>
  </thead>
  <tbody>
    



<?php
$c_id = $_SESSION['id'];
$room = returnRoomPreference($conn,$c_id);
$sql = sqlReturnCart($c_id);



$res=mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['food_id'];
                        $name = $row['name'];
                        $quantity = $row['quantity'];
                        $price = $row['price'];
                        //function sqlUpdateCartQty($id,$c_id,$qty){
                        ?>
                            
                        <tr>
                            <th scope="row"><?php echo $name;?></th>
                            <td>
                                <span class="btn btn-sm btn-secondary btn-minus"><b>-</b></span>
                                    <input onchange='updateQuantity(<?php echo $id;?>,this.value)' type="number" name="qty" class="qty" value=<?php echo $quantity?> min="1">
                                <span class="btn btn-sm btn-secondary btn-plus"><b>+</b></span>
                            </td>
                            <td><?php echo $price;?></td>
                            <td><button value=<?php echo $id;?> onclick="removeFromCart(this.value)" class="btn btn-danger"> Remove</button></td>
                        </tr>




                        <?php
                    }
                    $sum = returnTotalPrice($conn);
                    echo "<tr>
                            <td></td>
                            <th>Total:</th>
                            <th>BDT $sum.00</th>
                        </tr>";
                    echo "  </tbody>
                    </table>";
                    echo "<br>";

                    if($_SESSION['type_id']!=5){
                      echo "<input type='datetime-local' name='pickup' id=pickup><br>";
                      echo "<label for='room'>Deliver to Room: </label><input type='text' id='room' name='room' value=$room>";
                      echo "<a type=button class='btn btn-secondary' onclick='savePreference2()'>Save Room for Later</a><br>";
                    }
                    

                    echo "<a type='button' class='btn btn-primary' onclick='";
                    if($_SESSION['type_id']!=5){
                      echo "order()";
                    }else{
                      echo "guestOrder()";
                    }

                    echo "'>Order</a>";
                    echo "<a type='button' class='btn btn-danger' onclick='clearCart()'>Clear</a>";
                    echo "</div>";
                                
                }
                else
                {
                    echo "<div class='error'>Cart is empty.</div>";
                }

?>


    
    <?php //}else{}?>