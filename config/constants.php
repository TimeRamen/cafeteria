<?php 
    //Start Session
    session_start();
    
    
    //Create Constants to Store Non Repeating Values
    define('SITEURL', 'http://localhost/cafeteria/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'cafeteria');
    
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //Database Connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //SElecting Database

   if(empty($_SESSION['id'])){
    $_SESSION['id'] = generateRandomGuest($conn);
    $_SESSION['name'] = 'Guest';
    $_SESSION['type_id'] = 5;
   }


    $food_type = retFoodTypes($conn);
    $diet = retDiet($conn);

    function generateRandomGuest($conn){
        $g_id = "G".rand(1000000000,9999999999);
        $sql = "INSERT INTO user VALUES ('$g_id','','',5)";
        mysqli_query($conn,$sql);
        return $g_id;
    }

    function deleteAllGuestID($conn){
        $sql = "DELETE from cart WHERE c_id in 
        (select id from user where type_id = 5)";
        mysqli_query($conn,$sql);
        $sql = "DELETE from user where type_id = 5 AND id NOT LIKE 'GUEST'";//c_id='$c_id'
        mysqli_query($conn,$sql);
    }

    function deleteCurrentGuest($conn,$g_id){
        $sql = "DELETE from user where id = '$g_id'";
        mysqli_query($conn,$sql);
    }

    function guestOrder($conn,$g_id){
        $deliveryDate = date('Y-m-d H:i:s');
        $str = "INSERT into orders(room,pickup,c_id) values(null,'$deliveryDate','GUEST')";
        mysqli_query($conn,$str);
        $o_id = mysqli_insert_id($conn);
        
        $str = "INSERT into contains(order_id,food_id,quantity)
        select '$o_id',food_id,quantity from cart 
        where c_id = '$g_id'";
        mysqli_query($conn,$str);

        $str = sqlEmptyCart($g_id);
        mysqli_query($conn,$str);
        deleteCurrentGuest($conn,$g_id);
        return $o_id;
    }

    //queries
    function sqlSearch($search){
        return "SELECT * FROM food_items WHERE name LIKE '%$search%'";
    }
    function sqlCategoryFilter($id){
        return "SELECT * FROM food_items where food_type_id=$id";
    }
    function sqlAllFood(){
        return "SELECT * FROM food_items";
    }
    function sqlCategory(){
        return "SELECT * from food_type";
    }
    function sqlReturnFood($id){
        return "SELECT * FROM food_items WHERE id=$id";
    }
    function sqlReturnCart($c_id){
        return "SELECT food_id,name,quantity,(quantity*price) as price FROM cart join food_items on(cart.food_id=food_items.id) where c_id='$c_id'";
    }
    function sqlReturnTotalPrice(){
        return "SELECT sum(quantity*price) as sum FROM cart join food_items on(cart.food_id=food_items.id)";
    }
    function sqlEmptyCart($c_id){
        return "DELETE from cart where c_id='$c_id'";
    }
    function sqlDeleteFromCart($id,$c_id){
        return "DELETE from cart where food_id=$id and c_id='$c_id'";
    }
    function sqlUpdateCartQty($id,$c_id,$qty){
        return "UPDATE cart SET quantity=$qty where food_id=$id and c_id='$c_id'";
    }

    function retDietString($arr){
        $ret = "(select food_id from food_diet where diet_id in(";
        foreach($arr as $val){
            $ret .= strval($val).",";
        }
        $ret = substr($ret,0,-1)."))";
        return $ret;
    }


function retFoodTypes($conn){
    $sql = "SELECT food_type from food_type";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $arr = array();
    if($count>0)
    {
        while($row=mysqli_fetch_assoc($res))
        {
            array_push($arr,$row['food_type']);
        }
    }
    return $arr;
}
function retDiet($conn){
    $sql = "SELECT diet from dietary";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $arr = array();
    if($count>0)
    {
        while($row=mysqli_fetch_assoc($res))
        {
            array_push($arr,$row['diet']);
        }
    }
    return $arr;
}

function returnTotalPrice($conn){
    $sql = sqlReturnTotalPrice();
    $sum = mysqli_query($conn,$sql);
    $row= mysqli_fetch_assoc($sum);
    return (int)$row['sum'];
}    

function makeDietFilter($conn,$dietArr = array()){
    $flag1 = false;
    $flag2 = false;
    $retString = " ";
    $sql = "SELECT * from dietary WHERE free=0";
    $res = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($res);
    $in = array();
    if($count>0)
    {
        
        while($row=mysqli_fetch_assoc($res))
        {
            if(in_array(intval($row['id']),$dietArr)){
                $flag2 = true;
                array_push($in,$row['id']);
            }
            
        }
    }
    
    $sql = "SELECT * from dietary WHERE free=1";
    $res =  mysqli_query($conn,$sql);
    $count = mysqli_num_rows($res);
    $not = array();
    if($count>0)
    {
        
        while($row=mysqli_fetch_assoc($res))
        {
            if(in_array(intval($row['id']),$dietArr)){
                $flag1 = true;
                array_push($not,$row['id']);
            }
            
        }
    }
    if(($flag1||$flag2)){
        $retString .= "id ";
        if($flag1){
            $retString.=" not in ";
            $retString.=retDietString($not);
        }
        if($flag1&&$flag2){
            $retString.=" and id ";
        }
        if($flag2){
            $retString.=" in ";
            $retString.=retDietString($in);
        }
    }
    return $retString;

}

function masterFoodQuery($conn,$dietArr=array(),$budget=null,$search=null,$categoryFilter=null,$sort=null){
    //to do
    $dietFlag = !empty($dietArr);
    $budgetFlag = !is_null($budget);
    $searchFlag =!is_null($search);
    $categoryFlag =!is_null($categoryFilter);
    $prevFlag = false;
    $retString = "SELECT * FROM food_items WHERE ";
    if($dietFlag||$budgetFlag||$searchFlag||$categoryFlag){
        if($dietFlag){
            $retString .= makeDietFilter($conn,$dietArr);
            $prevFlag = true;
        }
        if($prevFlag){
            $retString.=" and ";
            $prevFlag = false;
        }
        if($budgetFlag){
            $retString.=" food_items.price<=(";
            $retString.=budgetCalc($budget);
            $retString.=")";
            $prevFlag = true;
        }
        if($prevFlag){
            $retString.=" and ";
            $prevFlag = false;
        }
        if($searchFlag){
            $retString.="food_items.name like '%$search%'";
            $prevFlag = true;
        }
        if($prevFlag){
            $retString.=" and ";
            $prevFlag = false;
        }
        if($categoryFlag){
            $retString.="food_items.food_type_id=$categoryFilter";
        }
        if(andIsLast($retString)==0){
            $retString = preg_replace('/\W\w+\s*(\W*)$/', '$1', $retString);
        }
    }else{
        $retString.="1";
    }
    //$retString .= "order by"
    $retString .= sortQuery($sort);
    //return mysqli_query($conn, $retString);
    return $retString;     
}
function budgetCalc($budget){
    
$str = "SELECT ";
$str .= strval($budget);
$str .= "- nvl(sum(quantity*price),0) as budget FROM cart join food_items on(cart.food_id=food_items.id)";
return $str;
}
function sortQuery($sort){
    $str ="";
    switch($sort){
        case 1:
            $str = " order by price asc"; 
            break;
        case 2:
            $str = " order by price desc";
            break;
        case 3:
            $str = " order by name asc";
            break;
        case 4:
            $str = " order by name desc";
            break;
        default:
            $str = "";
    }
    return $str;
    
}
function andIsLast($string){
    if(substr($string, -1) == ' ') {
        $string = substr($string, 0, -1);
    }
    $pieces = explode(' ', $string);
    $last_word = array_pop($pieces);
    return strcmp("and",$last_word);
}

function addPreferences($c_id,$budget){
    if($budget ==null){
        return "insert into preference values('$c_id',null,null) ";
    }else{
        return "insert into preference values('$c_id',null,$budget) ";
    }
}
function updatePreferences($c_id,$budget){
    if($budget ==null){
        return "update preference set budget=null where c_id='$c_id' ";
    }else{
        return "update preference set budget=$budget where c_id='$c_id' ";
    }
}
function addRoomPreference($c_id,$room){
    if($room ==null){
        return "insert into preference values('$c_id',null,null) ";
    }else{
        return "insert into preference values('$c_id',$room,null) ";
    }
}

function updateRoomPreferences($c_id,$room){
    if($room ==null){
        return "update preference set room=null where c_id='$c_id' ";
    }else{
        return "update preference set room=$room where c_id='$c_id' ";
    }
}


function addDietPreferences($c_id,$dietArr){
    if(!empty($dietArr)){
        $str = "insert into preference_dietary values";
        foreach($dietArr as $val){
            $str.="('$c_id',$val),";
        }
        $str = substr($str,0,-1);
        return $str;
    }
    else return "";
    
    //if dietarr is empty do something else
}
function deleteDietPreferences($c_id,$dietArr){
    $str = "DELETE FROM preference_dietary WHERE c_id='$c_id'  ";
    return $str;
}

function roomBudgetPreferenceExists($c_id,$conn){
    $sql = "SELECT * FROM preference WHERE c_id='$c_id'";
    $res = mysqli_query($conn,$sql);
    $flag = (mysqli_num_rows($res)>0);
    return $flag;
}
function dietPreferenceExists($c_id,$conn){
    $sql = "SELECT * FROM preference_dietary WHERE c_id='$c_id'";
    $res = mysqli_query($conn,$sql);
    $flag = (mysqli_num_rows($res)>0);
    return $flag;
}
function runMasterPreferenceQuery($conn,$c_id,$budget=null,$dietArr=array()){
    $str1 = "";
    $str2 = "";
    
    if(!roomBudgetPreferenceExists($c_id,$conn)){
        $str1 = addPreferences($c_id,$budget);
    }else{
        $str1 = updatePreferences($c_id,$budget);
    }
    if(!dietPreferenceExists($c_id,$conn)){
        $str2 = addDietPreferences($c_id,$dietArr);
    }else{
        $str2 = deleteDietPreferences($c_id,$dietArr);
        mysqli_query($conn,$str2);
        $str2 = addDietPreferences($c_id,$dietArr);
    }
    if(strcmp($str1,"")!=0){
        mysqli_query($conn,$str1);
    }
    if(strcmp($str2,"")!=0){
        mysqli_query($conn,$str2);
    }

}
function runMasterRoomQuery($conn,$c_id,$room=null){
    //$str = "";
    if(!roomBudgetPreferenceExists($c_id,$conn)){
        $str = addRoomPreference($c_id,$room);
    }else{
        $str = updateRoomPreferences($c_id,$room);
    }
    mysqli_query($conn,$str);

}

function returnRoomPreference($conn,$c_id){
    $str = "select room from preference where c_id = '$c_id'";
    $room = mysqli_query($conn,$str);

    $row=mysqli_fetch_assoc($room);
    if(empty($row['room'])) return "";
    else return $row['room'];
}

function returnBudgetPreference($conn,$c_id){
    $str = "select budget from preference where c_id = '$c_id'";
    $budget = mysqli_query($conn,$str);

    $row=mysqli_fetch_assoc($budget);
    if(empty($row['budget'])) return "";
    else return $row['budget'];
}

function returnDietPreference($conn,$c_id,$a_id){
    $str = "select allergen_id from preference_dietary where c_id = '$c_id' and allergen_id=$a_id";
    $res = mysqli_query($conn,$str);
    $count = mysqli_num_rows($res);
    if($count>0){ return "checked";}else return "";
}

function returnDietString($conn,$id){
    $sql = "SELECT free FROM dietary";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $arr = array();
    if($count>0)
    {
        while($row=mysqli_fetch_assoc($res))
        {
            $flag = intval($row['free']);

            $str = $flag > 0 ? "-Free" : " Friendly";
            array_push($arr,$str);
        }
    }
    return $arr[$id-1];
}


function renderDietPreference($conn,$diet,$diet_id,$checked){
    $str = "<div class=diet>
            <input type='checkbox' id='$diet' name='dietary' value=$diet_id onchange='renderFilter()' ";                     
    $str.= $checked." >";
    $str.="<label for='$diet'>".ucfirst($diet).returnDietString($conn,$diet_id)."</label>
    </div>";
    return $str;
}

function renderAllDietPreference($conn,$c_id){
    $arr = retDiet($conn);
    if($c_id == null){
        foreach($arr as $i => $val){
            echo renderDietPreference($conn,$val,$i+1,"");
        }
    }else{
        foreach($arr as $i => $val){
            echo renderDietPreference($conn,$val,$i+1,returnDietPreference($conn,$c_id,$i+1));
        }
    }
}

function startOrder($conn,$room = null,$deliveryDate,$c_id){
    //if($deliveryDate==null){$deliveryDate = new DateTime('now');}
    $str = "INSERT into orders(room,pickup,c_id) values('$room','$deliveryDate','$c_id')";
    mysqli_query($conn,$str);
    $str = addFromCart($c_id);
    mysqli_query($conn,$str);
    $str = sqlEmptyCart($c_id);//run this at the end.
    mysqli_query($conn,$str);
}
function addFromCart($c_id){
    return "insert INTO contains(order_id,food_id,quantity)
SELECT id,food_id,quantity
FROM orders join cart on orders.c_id=cart.c_id
where id = (SELECT MAX(id) FROM orders WHERE c_id='$c_id')";
}

function returnOrders($c_id){
    return "SELECT order_id, sum(price*quantity) as total, pickup,room,orders.c_id as c_id, paid FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    group by order_id
    having orders.c_id='$c_id'";
}
function returnOrderItems($order_id){
    return "select name,quantity,(quantity*price) as subtotal from contains
    join food_items on(contains.food_id=food_items.id) where order_id=$order_id ";
}

function returnAllOrders(){
    return "
    SELECT user.name as username,order_id, sum(price*quantity) as total, pickup,room,orders.c_id as c_id, paid FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    join user on (user.id=orders.c_id)
    group by order_id
    ";
}

function returnUnpaidOrders(){
    return "
    SELECT user.name as username,order_id, sum(price*quantity) as total, pickup,room,orders.c_id as c_id, paid FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    join user on (user.id=orders.c_id)
    where paid = 0
    group by order_id
    ";
}

function returnUnpaidOrdersCustomer($c_id){
    return "SELECT order_id, sum(price*quantity) as total, pickup,room,orders.c_id as c_id, paid FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    where paid = 0
    group by order_id
    having orders.c_id='$c_id'";
}

function sqlReturnExpenditure($year='year(CURRENT_DATE)'){
    return "SELECT sum(price*quantity) as total, month(pickup) as month FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    join user on (user.id=orders.c_id)
    where year(pickup) = $year and paid=1
    group by month(pickup)";
}
/*
SELECT sum(price*quantity) as total, paid FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    join user on (user.id=orders.c_id)
    group by paid
    having paid = 1;
 */

function sqlReturnYearlyRevenue($year='year(CURRENT_DATE)'){
    return "SELECT sum(price*quantity) as total, year(pickup) as year FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    join user on (user.id=orders.c_id)
    where paid = 1
    group by year(pickup) 
    having year = $year";
}

function sqlReturnExpenditureUser($c_id,$year='year(CURRENT_DATE)'){
    return "
    SELECT sum(price*quantity) as total, month(pickup) as month FROM
    orders join contains on (orders.id=contains.order_id)
    join food_items on(contains.food_id=food_items.id)
    join user on (user.id=orders.c_id)
    where year(pickup) = $year and user.id = '$c_id' and paid=1
    group by month(pickup)
    ";
}

function sqlRemoveOrder($conn, $order_id){
    $str = "DELETE from contains where order_id = $order_id";
    mysqli_query($conn,$str);
    $str = "DELETE from orders where id = $order_id";
    mysqli_query($conn,$str);
}

function reduceStockByQuantity($conn,$c_id){
    $str = "update food_items join cart
    on (food_items.id=cart.food_id)
    set stock = stock-quantity where cart.c_id = '$c_id';";
    mysqli_query($conn,$str);
}

function itemExceedingQuantityInCart($conn, $c_id){
    $sql = 
    "SELECT food_items.name as id from cart join food_items
    on (cart.food_id=food_items.id) where cart.c_id='$c_id'
    and quantity>stock limit 1";
    $res = mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    $count=mysqli_num_rows($res);
	if($count > 0){
        return $row['id'];
    }else{
        return 0;
    }
}

function markAsPaid($conn, $order_id){
    $sql = "UPDATE orders SET paid = 1 where id=$order_id";
    mysqli_query($conn,$sql);
}

function clearUnpaidOrders($conn){
    $sql = "delete from contains where order_id in (select id from orders where date(pickup) < CURRENT_DATE and paid = 0)";
    mysqli_query($conn,$sql);
    $sql ="delete from orders where date(pickup) < CURRENT_DATE and paid = 0";
    mysqli_query($conn,$sql);
}

function sqlUpdateStock($id,$stock){
    return
    "UPDATE food_items set stock = $stock where id = $id";
}

function sqlUpdateAllStock($stock){
    return
    "UPDATE food_items set stock = stock + $stock";
}

function renderAccordionItem($h2ID,$collapseID,$itemName,$itemBody){
    echo "<div class='accordion-item'>
        <h2 class='accordion-header' id='$h2ID'>
            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#$collapseID' aria-expanded='false' aria-controls='$collapseID'>
                $itemName
            </button>
        </h2>
        <div id='$collapseID' class='accordion-collapse collapse' aria-labelledby='$h2ID' data-bs-parent='#accordion'>
        <div class='accordion-body'>
            $itemBody
        </div>
        </div>
    </div>";
}

function renderOrderItems($res,$total,$room,$flag){
    $str = "<table class='table'>
    <thead>
      <tr>
        <th scope='col'>Item</th>
        <th scope='col'>Quantity</th>
        <th scope='col'>Subtotal</th>
      </tr>
    </thead>
    <tbody>
    ";
    while($row2=mysqli_fetch_assoc($res)){
                $name = $row2['name'];
                $quantity = $row2['quantity'];
                $subtotal = $row2['subtotal'];
                $str .= "<tr>
                            <td>$name</td>
                            <td>$quantity</td>
                            <td>$subtotal</td>
                        </tr>";
            }

            $str .= "</tbody>
            </table>";
            $str .= "<p><strong>Total</strong>: BDT ".$total.".00</p>";
            if($room != null){
                if($flag){
                    $str .= "<p><strong>Deliver";
                }else{
                    $str .= "<p><strong>Was delivered";
                }
                $str .=  " to room</strong>: ".$room."</p>";
            }
            return $str;
            //to do : maybe change where you want to deliver it to?
    }
/*
function sqlReturnCart(){
        return "SELECT food_id,name,quantity,(quantity*price) as price FROM cart join food_items on(cart.food_id=food_items.id)";
    }
    function sqlReturnTotalPrice(){
        return "SELECT sum(quantity*price) as sum FROM cart join food_items on(cart.food_id=food_items.id)";
    }
 */
/*
insert INTO contains(order_id,food_id,quantity)
SELECT id,food_id,quantity
FROM orders join cart on orders.c_id=cart.c_id
where id = $order

example

select * from food_items
        where id in (select food_id from food_diet where diet_id in(1,2))
		and id not in (select food_id from food_diet where diet_id in(3,4,5))
		and food_items.price<=(
SELECT 200 - nvl(sum(quantity*price),0) as budget FROM cart join food_items on(cart.food_id=food_items.id)
)
and food_items.name like "%veg%"
and food_items.food_type_id=1
*/

?>