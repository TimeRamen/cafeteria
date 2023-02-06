$('body').on("click",'.btn-minus',function(){
    var qty = $(this).siblings('input').val()
    qty = qty > 1 ? parseInt(qty) - 1 : 1;
    $(this).siblings('input').val(qty).trigger('change')
})

$('body').on("click",'.btn-plus',function(){
    var qty = $(this).siblings('input').val()
        qty = parseInt(qty) + 1;
        $(this).siblings('input').val(qty).trigger('change')
})

addToCartEvents();
function addToCartEvents(){
    let allAddToCart = document.getElementsByClassName("add_to_cart");
    let allQuantity = document.getElementsByClassName("qty");

    for(let i = 0;i<allQuantity.length;i++){
        allAddToCart[i].addEventListener("click",()=>{
        
            let x = allAddToCart[i].value;
            let y = allQuantity[i].value;
            $.ajax({
                url:'config/ajax.php?action=add_to_cart',
                method:'POST',
                data:{
                    id: x,
                    qty: y
                },
                success:function(resp){
                    console.log("data sent "+x+","+y);
                    if(resp == 1){
                        alertify.success('Item added to Cart');
                    }else{
                        console.log(resp);
                        alertify.message('Item already in Cart');
                    }
                },
                error:function(){
                    alert("error");
                }
            })
        })
    }
}

function changeStock(id,stock){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        alertify.success('Stock updated!');
    }
    };
    xmlhttp.open("GET","functions/changeStock.php?id="+id+"&stock="+stock,true);
    xmlhttp.send();
}

function getCheckedCheckboxesFor(checkboxName) {
var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
Array.prototype.forEach.call(checkboxes, function(el) {
values.push(el.value);
});
return values;
}




function renderFilter() {
    let search =document.getElementById("search").value;
    let dietArr = getCheckedCheckboxesFor("dietary");
    let dietString = JSON.stringify(dietArr).replaceAll('"','');
    let budget =document.getElementById("budget").value;
    let select = document.getElementById("category-select");
    let category = select.options[select.selectedIndex].value;
    //if(category=="--Category Select--"){category=0;}
    let select2 = document.getElementById("sort");
    let sort = select2.options[select2.selectedIndex].value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        
    document.getElementById("ajax-clear").innerHTML = this.responseText;
    addToCartEvents();
    }
    };
    xmlhttp.open("GET","functions/food-filter.php?search="+search+"&diet="+dietString+"&budget="+budget+"&category="+category+"&sort="+sort,true);
    xmlhttp.send();

}

function saveToPreferences(){
    let dietArr = getCheckedCheckboxesFor("dietary");
    let dietString = JSON.stringify(dietArr).replaceAll('"','');
    let budget =document.getElementById("budget").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    alertify.success('Preferences saved!');
    console.log(this.responseText);
    }
    };

    xmlhttp.open("GET","functions/preferences.php?diet="+dietString+"&budget="+budget,true);
    xmlhttp.send();

}

function addStock(stock){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    alertify.success('Added' +stock+ 'to each stock!');
    setTimeout(function(){window.location.reload();},500);
    }
    };

    xmlhttp.open("GET","functions/addStock.php?stock="+stock,true);
    xmlhttp.send();
}