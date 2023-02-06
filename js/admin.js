function clearGuests(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Guest carts cleared.');
        }
    };
    xmlhttp.open("POST","functions/guestClear.php",true);
    xmlhttp.send();
}