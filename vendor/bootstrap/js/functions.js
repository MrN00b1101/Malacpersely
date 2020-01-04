
//'http://localhost/Malacpersely/phpApi.php';
//'http://mrnoobrft.ddns.net/Malacpersely/phpApi.php'

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


function login(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "phpApi.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");


    xmlhttp.onload = function () {
        var users = JSON.parse(xmlhttp.responseText);
        if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
            alert(xmlhttp.status_message);
        } else {
            alert(xmlhttp.status_message);
        }
    }

    xmlhttp.send(JSON.stringify(
        { 
    "com": "login",
    "Mail": document.getElementById("inputEmailLog").value,
    "password": document.getElementById("inputPasswordLog").value
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
    var minDat = '2019-12-01';
    var maxDat = 'null';
    var personal = 1;
    var token = getCookie("Token");
    
    var param = "?user="+user+"&cat="+cat+"&minVal="+minVal+"&maxVal="+maxVal+"&minDat='"+minDat+"'&maxDat="+maxDat+"&com="+com+"&personal="+personal+"&token="+token;

    request.open('GET', 'phpApi.php'+param, true)

    request.onload = function() {
    var obj = JSON.parse(request.response);
    //alert(obj.length);
    var inComeId = 1;
    var costId = 1;
    var inOutSum = 0;
    for(i=0; i< obj.length;i++){
       // inOutSum += obj[i].Value;
        if(obj[i].Value > 0)
        {
            document.getElementById("inComeId").innerHTML += inComeId+"<br>";
            inComeId++;
            document.getElementById("inComeValue").innerHTML += obj[i].Value+"<br>";
            document.getElementById("inComeDate").innerHTML += obj[i].TranDate+"<br>";
        }
        else{
        document.getElementById("costId").innerHTML += costId+"<br>";
        costId++;
        document.getElementById("costValue").innerHTML += obj[i].Value+"<br>";
        document.getElementById("costDate").innerHTML += obj[i].TranDate+"<br>";
        }
    }
    //document.getElementById("inOutSum").innerHTML = inOutSum;

 

}
// Send request
request.send()
//alert(getCookie("Token"));
}
function logout(){
    var request = new XMLHttpRequest();
 
    var param = "?com=logout";

    request.open('GET', 'phpApi.php'+param, true)

    request.onload = function() {
    
    alert(request.response);
    
    
   
        

}
// Send request
request.send()
}