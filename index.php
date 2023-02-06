
<style>
.diet{
  text-align: left;
}
.col1,.col2 {
  float:left;
  width:40%;
  
}
.col1{
    margin: 2% 0 0 10%;
}
.col2{
    margin: 0 10% 2% 0;
}
.col2 label{
    margin: 10;
}
.align-items-start {
  align-items: flex-start !important;
}
.qty-div{
    margin: 0 0 10 0;
}

input {
  margin: 0.4rem;
}

@charset "UTF-8";
body {
  color: #2c3e50;
  background: #ecf0f1;
  padding: 0 1em 1em;
}

h1 {
  margin: 0;
  line-height: 2;
  text-align: center;
}

h2 {
  margin: 0 0 0.5em;
  font-weight: normal;
}

#chck {
  position: absolute;
  opacity: 0;
  z-index: -1;
}

#chck1{
    display: none;
}

.row {
  display: flex;
}
.row .col {
  flex: 1;
}
.row .col:last-child {
  margin-left: 1em;
}

/* Accordion styles */
.tabs {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 4px -2px rgba(0, 0, 0, 0.5);
}

.tab {
  width: 100%;
  color: white;
  overflow: hidden;
}
.tab-label {
  display: flex;
  justify-content: space-between;
  padding: 1em;
  background: #2c3e50;
  font-weight: bold;
  cursor: pointer;
  /* Icon */
}
.tab-label:hover {
  background: #1a252f;
}
.tab-label::after {
  content: "❯";
  width: 1em;
  height: 1em;
  text-align: center;
  transition: all 0.35s;
}
.tab-content {
  max-height: 0;
  padding: 0 1em;
  color: #2c3e50;
  background: white;
  transition: all 0.35s;
}
.tab-close {
  display: flex;
  justify-content: flex-end;
  padding: 1em;
  font-size: 0.75em;
  background: #2c3e50;
  cursor: pointer;
}
.tab-close:hover {
  background: #1a252f;
}

#chck1:checked + .tab-label {
  background: #1a252f;
}
#chck1:checked + .tab-label::after {
  transform: rotate(90deg);
}
#chck1:checked ~ .tab-content {
  max-height: 100vh;
  padding: 1em;
}

</style>


    <?php include('partials-front/menu.php'); 
    // if(!empty($_SESSION['id'])){
    //   $c_id = $_SESSION['id'];
    //   $budget = returnBudgetPreference($conn,$c_id);
    // }
    $c_id = $_SESSION['id'];
    $budget = returnBudgetPreference($conn,$c_id);
    // echo $c_id;
    ?>



    <section class="food-search text-center">
        <div class="container">
                <input id=search type="search" name="search" placeholder="Search for Food.." onchange="renderFilter()">
                <br>





                
<div class="row">
  <div class="col">
    <div class="tabs">
      <div class="tab">
        <input type="checkbox" id="chck1">
        <label class="tab-label" for="chck1">
          <?php
          if($_SESSION['type_id']!=5){
            echo "Preferences";
          }else{
            echo "Filter";
          } 
          ?></label>
        <div class="tab-content">
          
        <div class="row align-items-start">
                    <div class=col1>
                          <?php
                          renderAllDietPreference($conn,$c_id);
                          ?>
                    </div>
                    <div class=col2>
                        <fieldset>
                            <label for="budget">Budget</label><input type="number" id="budget" name="budget" min="100" max="100000" step='100' onchange="renderFilter()" <?php if(isset($_SESSION['id'])){?>value = <?php echo $budget;  }//the value from preferences.?>>
                            <select name="category" id="category-select" onchange="renderFilter()">
                                <option value=0>--Category Select--</option>
                                <option value=1>Breakfast</option>
                                <option value=2>Light Snacks</option>
                                <option value=3>Thai/Chinese Food</option>
                                <option value=4>Lunch</option>
                                <option value=5>Fast Food</option>
                                <option value=6>Desserts</option>
                                <option value=7>Drinks</option>
                            </select>

                            <br>
                            <select name="sort" id="sort" onchange="renderFilter()">
                                <option>--Sort--</option>
                                <option value=1>Price Ascending</option>
                                <option value=2>Price Descending</option>
                                <option value=3>Alphabetical Ascending</option>
                                <option value=4>Alphabetical Descending</option>
                            </select>

                        </fieldset>
                    </div>
                </div>
 <?php if($_SESSION['type_id']!=5){?>
                <input type="button" value="Save to Preferences" class="btn btn-primary" style="width: 20%;" onclick="saveToPreferences()">
     <?php }  ?>
          
        </div>
      </div>
    </div>
  </div>


        </div>
    </section>
    

    
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <button class='btn' onclick='addStock(10)'>Add 10 To All</button>
<div id=ajax-clear>
            <?php 
                $sql = masterFoodQuery($conn);
                //echo $sql;
                $res=mysqli_query($conn, $sql);
                //$res = masterFoodQuery($conn);
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
                        ?>
                        
                        <div class="food-menu-box">

                            <div class="food-menu-desc">
                                <h4><?php echo $name; ?></h4>
                                <p class="food-price">BDT <?php echo $price; ?>.00</p>
                                <?php if($_SESSION['type_id']!=4){?>
                                <p>Stock: <?php echo $stock;?></p>
                                <?php }else{?>
                                  <span>Stock: </span>
                                  <span class="btn btn-sm btn-secondary btn-minus"><b>-</b></span>
                                        <input onchange='changeStock(<?php echo $id;?>,this.value)'type="number" name="stock" class="stock" value=<?php echo $stock;?> min="0">
                                        <span class="btn btn-sm btn-secondary btn-plus"><b>+</b></span>
                                  <?php }?>
                                <p class="food-detail">
                                    <?php echo $category; ?>
                                </p>
                                <br>
                                <div class="d-flex jusctify-content-center col-md-12">
                                    <div class="qty-div">
                                        <span class="btn btn-sm btn-secondary btn-minus"><b>-</b></span>
                                        <input type="number" name="qty" class="qty" value="1" min="1">
                                        <span class="btn btn-sm btn-secondary btn-plus"><b>+</b></span>
                                    </div>
                                    
                                    <button class="btn btn-primary btn-block btn-sm col-sm-4 add_to_cart" type="button" value=<?php echo $id?>>Add to Cart</button>
                                    <input type="hidden" name="food_id" class="hidden_id" value=<?php echo $id?> readonly>
                                    
                                </div>
                                
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>Food not found.</div>";
                }
            ?>

            

            </div>

            <div class="clearfix"></div>

            

        </div>

    </section>

    <?php include('partials-front/footer.php'); ?>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="js\jquery-3.6.3.min.js"></script>
    <script src="js\alertify\alertify.min.js"></script>
    <script src="js\food.js">
    </script>