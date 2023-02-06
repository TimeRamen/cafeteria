<?php
include '../config/constants.php';
error_reporting(0);
$rn=$_GET['rn'];
$fn=$_GET['fn'];
$ln=$_GET['ln'];
$em=$_GET['em'];
$kn=$_GET['kn'];
$x = array();

$sql1 = "SELECT dietary.diet as diet from food_diet INNER JOIN dietary on food_diet.diet_id = dietary.id WHERE food_diet.food_id ='$rn' ";
$query1 = mysqli_query($conn,$sql1);
while ($info = mysqli_fetch_array($query1)) {
    array_push($x,$info['diet']) ;
}


?>

<html>
<head>
    <title>
        UPDATE FOOD
    </title>

    <link rel="stylesheet" type="text/css" href="../css/style2.css">

</head>
<body>
    
    <h1 style="color: black;">Food Update</h1>
    <form action="" method="POST">
    <table>
        <tr>
        <td>ID</td>
        <td><input type="text" value="<?php echo("$rn") ?>" name="id" readonly></td>
        </tr>
        <tr>
        <td>Name</td>
        <td><input type="text" value="<?php echo("$fn") ?>" name="name" required></td>
        </tr>
        <tr>
        <td>Price</td>
        <td><input type="text" value="<?php echo("$ln") ?>" name="price" required></td>
        </tr>
        <tr>
        <td>Stock</td>
        <td><input type="text" value="<?php echo("$kn") ?>" name="stock" required></td>
        </tr>
        <tr>
            <br>
        <td>Food Type</td>
        <td>
        <?php
                      $sql_type_of_food = "SELECT id,food_type FROM food_type"  ;
                      $query_type_of_food = mysqli_query($conn,$sql_type_of_food);
                      ?>
                      <select name="type_of_food" >
                        <?php
                      while($data_type_of_food = mysqli_fetch_assoc($query_type_of_food)){
                        ?>
                            <option value= <?php echo $data_type_of_food['id'] ?> <?php if($em == $data_type_of_food['food_type']){echo "selected";} ?>><?php echo $data_type_of_food['food_type'] ?></option>
                        <?php
                      }
                ?>
                </select>
        </td>
        </tr>
        <tr>
            <td>Allergen</td>
           
        <td>
        <?php
                $sql_type_of_diet = "SELECT id,diet FROM dietary"  ;
                $query_type_of_diet = mysqli_query($conn,$sql_type_of_diet);
                while($data_type_of_diet = mysqli_fetch_assoc($query_type_of_diet)){
                    ?>
                <input type="checkbox" name="diet_type[]" value=<?php echo $data_type_of_diet['id'] ?> <?php if(in_array($data_type_of_diet['diet'],$x)) 
                            {echo "checked";} ?>><label><?php echo $data_type_of_diet['diet'] ?></label>
                    <?php
                }

                ?>

            </td>
        </tr>
        </form>
    </table>
    <div>
           <a href="admin_to_items.php" id="back_in">Back </a>
            <input type="submit" id="button" name="submit" value="Update">
        </div>
    
   
</body>
</html>
<?php
if($_POST['submit']){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $Food_Type = $_POST['type_of_food'];
    $u = $_POST['diet_type'];

    $sql_num="SELECT id from dietary";
    $query_num = mysqli_query($conn, $sql_num);
    while($data_num = mysqli_fetch_assoc($query_num)){
        $val=$data_num['id'];
        if(!in_array($data_num['id'],$u)){
            $qu1 = "DELETE FROM food_diet WHERE food_diet.food_id='$rn' AND food_diet.diet_id= '$val'";
            $qu_run1 = mysqli_query($conn,$qu1);
        }
    }

    foreach($u as $it){
        $qu = "INSERT INTO food_diet (food_id,diet_id) VALUES ('$rn','$it')";
        $qu_run = mysqli_query($conn,$qu);
    }

    $sql2 = "UPDATE food_items SET id ='$id',name ='$name',price ='$price',stock='$stock' WHERE id='$id' ";
    $data = mysqli_query($conn, $sql2);
    //echo "<script>console.log('$sql2')</script>";
    if($data){
        echo "<script>alert('Record Updated')</script>";
        
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT ="0;URL= 'http://localhost/cafeteria/admin/admin_to_items.php'">
        <?php

    }
    else{
        echo "Failed to update";
    }
}

?>
