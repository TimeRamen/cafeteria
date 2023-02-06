<?php 
include('../config/constants.php');
$search = $_GET['search'] == ""?null:$_GET['search'] ;
$dietString = $_GET['diet'];
$budget = $_GET['budget']==""?null:strval($_GET['budget']);
$category = $_GET['category']==0?null:$_GET['category'];
$sort = $_GET['sort']==0?null:$_GET['sort'];

$diet = json_decode($dietString);

                $sql = masterFoodQuery($conn,$diet,$budget,$search,$category,$sort);
                
                $res=mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $name = $row['name'];
                        $category = $food_type[$row['food_type_id']-1];
                        $price = $row['price'];
                        $stock = $row['stock'];

                        echo "
                        <div class='food-menu-box'>

                            <div class='food-menu-desc'>
                                <h4>$name</h4>
                                <p class='food-price'>BDT $price.00</p>
                                <p>Stock: $stock</p>
                                <p class='food-detail'>
                                    $category
                                </p>
                                <br>
                                <div class='d-flex jusctify-content-center col-md-12'>
                                    <div class='qty-div'>
                                        <span class='btn btn-sm btn-secondary btn-minus'><b>-</b></span>
                                        <input type=number name=qty class=qty value=1 min=1>
                                        <span class='btn btn-sm btn-secondary btn-plus'><b>+</b></span>
                                    </div>
                                    <button class='btn btn-primary btn-block btn-sm col-sm-4 add_to_cart' type=button value=$id>Add to Cart</button>
                                    <input type=hidden name=food_id class=hidden_id value=$id readonly>
                                </div>
                                
                            </div>
                        </div>
                        ";

                        
                    }
                }
                else
                {
                    echo "<div class='error'>Food not found.</div>";
                }

                ?>