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

function guestOrder(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Order placed.');
            let str = this.responseText;
            console.log();
            setTimeout(function(){
                document.querySelector("body").innerHTML = str;
            },500);

        }
    };
    xmlhttp.open("GET","functions/guestOrder.php",true);
    xmlhttp.send();
}

function removeFromCart(id){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Item removed from cart.');
            console.log(id);
            setTimeout(function(){window.location.reload();},500);
        }
    };

    xmlhttp.open("GET","functions/removeFromCart.php?id="+id,true);
    xmlhttp.send();


}

function clearCart(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Cart emptied.');
            setTimeout(function(){window.location.reload();},500);
            
        }
    };

    xmlhttp.open("POST","functions/clearCart.php",true);
    xmlhttp.send();
}


function order(){
        let room = document.getElementById("room").value;
            let delivery = document.getElementById("pickup").value;
            let current = new Date();
            let cDate = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate();
            let cTime = current.getHours() + ":" + current.getMinutes() + ":" + current.getSeconds();
            let dateTime = cDate + ' ' + cTime;

            if(delivery == ""){
                delivery=dateTime;
            }else{
                delivery=delivery.replace('T',' ');
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                    let str = this.responseText;
                    alertify.success(str);
                    console.log(str);
                    //setTimeout(function(){window.location.reload();},500);
                }
            };
            xmlhttp.open("GET","functions/order.php?room="+room+"&pickup="+delivery,true);
            xmlhttp.send();

}



function savePreference2(){
    let room = document.getElementById("room").value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Room preference saved!');
            setTimeout(function(){window.location.reload();},500);
        }
    };
    xmlhttp.open("GET","functions/roomPref.php?room="+room,true);
    xmlhttp.send();
}

function updateQuantity(food_id,quantity){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Quantity changed!');
            setTimeout(function(){window.location.reload();},500);
        }
    };
    xmlhttp.open("GET","functions/updateCart.php?id="+food_id+"&qty="+quantity,true);
    xmlhttp.send();
}
