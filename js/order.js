function removeOrder(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Preorder removed.');
            //console.log(id);
            setTimeout(function(){window.location.reload();},500);
        }
    };

    xmlhttp.open("GET","functions/removeOrder.php?id="+id,true);
    xmlhttp.send();
}

function markAsPaid(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Order marked as paid.');
            //console.log(id);
            setTimeout(function(){window.location.reload();},500);
        }
    };

    xmlhttp.open("GET","functions/markAsPaid.php?id="+id,true);
    xmlhttp.send();
}

function ClearAllUnpaid(){
  var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            alertify.success('Cleared all unpaid orders.');
            //console.log(id);
            setTimeout(function(){window.location.reload();},500);
        }
    };

    xmlhttp.open("GET","functions/clearUnpaid.php",true);
    xmlhttp.send();
}

function renderExpenditure(year){
    let div = document.getElementById("expenditure");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
            let body = this.responseText;
            alertify.success('Rendering new yearly expenditure.');
            //console.log(id);
            //setTimeout(function(){window.location.reload();},500);
            div.innerHTML = body;
        }
    };

    xmlhttp.open("GET","functions/renderExpenditure.php?year="+year,true);
    xmlhttp.send();
}

function renderUnpaid(){
    
    let div = document.getElementById("accordion");
    let check = document.getElementById("unpaid").checked;
    if(check){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
                let body = this.responseText;
                alertify.success('Rendering orders that have not yet been paid.');
                //console.log(id);
                //setTimeout(function(){window.location.reload();},500);
                div.innerHTML = body;
            }
        };
    
        xmlhttp.open("GET","functions/renderUnpaid.php",true);
        xmlhttp.send();
    }else{
        window.location.reload();
    }
    
}
/*
const labels = Utils.months({count: 12});
const data = {
  labels: labels,
  datasets: [{
    label: 'My First Dataset',
    data: [65, 59, 80, 81, 56, 55, 40],
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
};

const config = {
    type: 'line',
    data: data,
  };

var xyValues = [
    {x:50, y:7},
    {x:60, y:8},
    {x:70, y:8},
    {x:80, y:9},
    {x:90, y:9},
    {x:100, y:9},
    {x:110, y:10},
    {x:120, y:11},
    {x:130, y:14},
    {x:140, y:14},
    {x:150, y:15}
    ];

var chart = new Chart("expense",{
    type: "scatter",
    data: {
        datasets: [{
                pointRadius: 4,
                pointBackgroundColor: "rgba(0,0,255,1)",
                data: xyValues
            }]
    },
    options: {}
});*/