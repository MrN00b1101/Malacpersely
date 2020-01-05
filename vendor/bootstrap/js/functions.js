
//'http://localhost/Malacpersely/phpApi.php';
//'http://mrnoobrft.ddns.net/Malacpersely/phpApi.php'

window.onload = function() {
    this.getCategoryList();
    this.getTranList();
};

function loggin(){
    
    var loginReq = new XMLHttpRequest();
    loginReq.open("POST", "phpApi.php", true);
    loginReq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");


    loginReq.onload = function () {
        var users = JSON.parse(loginReq.responseText);
        if (loginReq.readyState != 4 || loginReq.status == "0") {
            alert("Hiba a bejelentkezésnél");   
        }
    }

    loginReq.send(JSON.stringify(
        { 
    "com": "login",
    "Name": document.getElementById('inputNameLog').value,
    "password": document.getElementById('inputPasswordLog').value,
     }));
}
function newUser(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "phpApi.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");


    xmlhttp.onload = function () {
        var users = JSON.parse(xmlhttp.responseText);
        if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
            alert(xmlhttp.status_message);
        } else {
            alert("Sikeres regisztráció! Kérlek jelentkezz be!");
        }
    }

    xmlhttp.send(JSON.stringify(
        { 
    "com": "user",
    "name": document.getElementById("inputUserName").value,
    "mail": document.getElementById("inputEmailReg").value,
    "pass": document.getElementById("inputPassword").value,
    }));
}



function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function getTranList(){
    var request = new XMLHttpRequest();
    var com = 'tran';
    var user = 9;
    var cat = 'null';
    var minVal = 'null';
    var maxVal = 'null';
    var minDat = '2019-01-30';
    var maxDat = 'null';
    var personal = 0;
    var token = getCookie("Token");
    
    var param = "?user="+user+"&cat="+cat+"&minVal="+minVal+"&maxVal="+maxVal+"&minDat='"+minDat+"'&maxDat="+maxDat+"&com="+com+"&personal="+personal+"&token="+token;

    request.open('GET', 'phpApi.php'+param, false)

    request.onload = function() {
       
    var obj = JSON.parse(request.response);
    //alert(obj.length);
   var inComeId = 1;
   var costId = 1;
   var inOutSum = 0;
    for(i=0; i< obj.length;i++){
        if(obj[i].Value > 0)
        {
            document.getElementById("inComeId").innerHTML += inComeId+"<br>";
            inComeId++;
            document.getElementById("inComeCategory").innerHTML += obj[i].TranCatId+"<br>";
            document.getElementById("inComeValue").innerHTML += obj[i].Value+"<br>";
            document.getElementById("inComeDate").innerHTML += obj[i].TranDate+"<br>";
            document.getElementById("inOutSum").innerHTML += obj[i].TranDate+"<br>";
            inOutSum+=parseInt(obj[i].Value);
        }
        else{
        document.getElementById("costId").innerHTML += costId+"<br>";
        costId++;
        document.getElementById("costCategory").innerHTML += obj[i].TranCatId+"<br>";
        document.getElementById("costValue").innerHTML += obj[i].Value+"<br>";
        document.getElementById("costDate").innerHTML += obj[i].TranDate+"<br>";
        inOutSum+=parseInt(obj[i].Value);
        }
}
document.getElementById("inOutSum").innerHTML = inOutSum;
}
// Send request
request.send()
//alert(getCookie("Token"));
}


function getCategoryList(){
    var request = new XMLHttpRequest();
    var com = 'cat';
    var user = 9;
    var fam = 0;
    var token = getCookie("Token");
    
    var param = "?user="+user+"&com="+com+"&fam="+fam+"&token="+token;

    request.open('GET', 'phpApi.php'+param, false)

    request.onload = function() {
    var obj = JSON.parse(request.response);

    for(i=0; i< obj.length;i++){
        document.getElementById("getCategories1").innerHTML +=obj[i].Name+"<br>";
        document.getElementById("getCategories2").innerHTML +=obj[i].Name+"<br>";
        document.getElementById("getCategories3").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";
      //  document.getElementById("getCategories4").innerHTML +='<option id="' + i + '">' +obj[i].Name+'</option>'+"<br>";
      
    }

}
// Send request
request.send()
//alert(getCookie("Token"));
}



function newTranzaction(){
    var xmlhttp = new XMLHttpRequest();
    var com = 'tran';
    var user = 9;
    var cat = 3;
    
    var el = document.getElementById('getCategories3');
    var x = el.options[el.selectedIndex].value;
    var catArray = x.split(" - ");
    var cat = parseInt(catArray[0]);
    alert(parseInt(catArray[0]));
  /*  var el = document.getElementById('getCategories3');
    var cat = el.options[el.selectedIndex].value;*/
    
    var value = document.getElementById('inputIncome').value;
    var personal = 0;
    var token = getCookie("Token");
    //var param = "?uId="+user+"&catId="+cat+"&value="+value+"&com="+com+"&personal="+personal+"&token="+token;
    xmlhttp.open("POST", "phpApi.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");


    xmlhttp.onload = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
            alert(xmlhttp.status_message);
        } else {
            alert("Tranzakció sikeresen hozzáadva!");
        }
    }


    xmlhttp.send(JSON.stringify(
        { 
    "com": com,
    "uId": user,
    "catId" : cat,
    "value" : value,
    "personal" : personal,
    "token" : token
    }));
}



function logout(){
    var request = new XMLHttpRequest();
 
    var param = "?com=logout";

    request.open('GET', 'phpApi.php'+param, false)

    request.onload = function() {
    
    alert(request.response);

}
// Send request
request.send()
}