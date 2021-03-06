
//'http://localhost/Malacpersely/phpApi.php';
//'http://mrnoobrft.ddns.net/Malacpersely/phpApi.php'

window.onload = function() {
    if(this.getCookie("Token") != "")
    {
        
       
        this.getCategoryList();
        this.getTranList();
        
    }

};



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
    "password": document.getElementById('inputPasswordLog').value
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
    var user = getCookie("Id");
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

  
    document.getElementById("inComeId").innerHTML ="";
    document.getElementById("inComeCategory").innerHTML ="";
    document.getElementById("inComeValue").innerHTML ="";
    document.getElementById("inComeDate").innerHTML ="";
    
    document.getElementById("costId").innerHTML ="";
    document.getElementById("costCategory").innerHTML ="";
    document.getElementById("costValue").innerHTML ="";
    document.getElementById("costDate").innerHTML ="";

    document.getElementById("updateTrans").innerHTML ="";
    document.getElementById("deleteTrans").innerHTML ="";
 
    document.getElementById("updateTrans2").innerHTML ="";
    document.getElementById("deleteTrans2").innerHTML ="";
    
    //alert(obj.length);
   var inComeId = 0;
   var costId = 0;
   var inOutSum = 0;
   var inSum = 0;
   var outSum = 0;
    for(i=0; i< obj.length;i++){
        if(obj[i].Value > 0)
        {
            inComeId++;
            document.getElementById("inComeId").innerHTML += inComeId+"<br>";
            document.getElementById("inComeCategory").innerHTML += obj[i].Category+"<br>";
            document.getElementById("inComeValue").innerHTML += obj[i].Value+"<br>";
            document.getElementById("inComeDate").innerHTML += obj[i].TranDate+"<br>";
            inOutSum+=parseInt(obj[i].Value);
            inSum+=parseInt(obj[i].Value);
        }
        else{
        costId++;
        document.getElementById("costId").innerHTML += costId+"<br>";
        document.getElementById("costCategory").innerHTML += obj[i].Category+"<br>";
        document.getElementById("costValue").innerHTML += obj[i].Value+"<br>";
        document.getElementById("costDate").innerHTML += obj[i].TranDate+"<br>";
        inOutSum+=parseInt(obj[i].Value);
        outSum+=parseInt(obj[i].Value);
        }
    }

    for(i=0; i< inComeId;i++){
        document.getElementById("updateTrans").innerHTML += '<input id="update' + i + '" type="radio" value="' + i+'" name="updatee"></input>'+"<br>";
        document.getElementById("deleteTrans").innerHTML += '<input id="delete' + i + '" type="checkbox" value="' + i+'" name="deletee"></input>'+"<br>";
    }

    for(i=0; i< costId;i++){
        document.getElementById("updateTrans2").innerHTML += '<input id="update' + i + '" type="radio" value="' + i+'" name="updatee"> </input>'+"<br>";
        document.getElementById("deleteTrans2").innerHTML += '<input id="delete' + i + '" type="checkbox" value="' + i+'" name="deletee">  </input>'+"<br>";

    }

document.getElementById("inOutSum").innerHTML = inOutSum;
document.getElementById("userNameHere").innerHTML = getCookie("User");
document.getElementById("inSum").innerHTML = inSum;
document.getElementById("outSum").innerHTML = outSum;

}
// Send request
request.send()
//alert(getCookie("Token"));
}

function getCategoryList(){
    var request = new XMLHttpRequest();
    var com = 'cat';
    var user = getCookie("Id");
    var fam = 0;
    var token = getCookie("Token");
    
    var param = "?user="+user+"&com="+com+"&fam="+fam+"&token="+token;

    request.open('GET', 'phpApi.php'+param, false)

    request.onload = function() {
    var obj = JSON.parse(request.response);

    document.getElementById("getCategories1").innerHTML ="";
    document.getElementById("getCategories2").innerHTML ="";
    document.getElementById("getCategories3").innerHTML ="";
    document.getElementById("getCategories4").innerHTML ="";
    document.getElementById("getCategories5").innerHTML ="";

    for(i=0; i< obj.length;i++){
        document.getElementById("getCategories1").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";
        document.getElementById("getCategories2").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>';
        document.getElementById("getCategories3").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";
        document.getElementById("getCategories4").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";
        document.getElementById("getCategories5").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";

    }
}
// Send request
request.send()
//alert(getCookie("Token"));
}

function newTranzaction(){
    var xmlhttp = new XMLHttpRequest();
    var com = 'tran';
    var user = getCookie("Id");
    
    var el = document.getElementById('getCategories3');
    var x = el.options[el.selectedIndex].value;
    var catArray = x.split(" - ");
    var cat = parseInt(catArray[0]);

    var value = document.getElementById('inputIncome').value;
    var personal = 0;
    var token = getCookie("Token");
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
    window.onload();
}

function newCategory(){
    var xmlhttp = new XMLHttpRequest();
    var com = 'cat';
    var name = document.getElementById('inputCategory').value;
   
    var creaId = getCookie("Id");
    var global = 0;
    var token = getCookie("Token");
    xmlhttp.open("POST", "phpApi.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xmlhttp.onload = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
            alert(xmlhttp.status_message);
        } else {
            alert("Kategória sikeresen hozzáadva!");
        }
    }

    xmlhttp.send(JSON.stringify(
        { 
    "com": com,
    "name" : name,
    "creaId" : creaId,
    "global" : global,
    "token" : token
    }));
}

function deleteTransaction(){
    var request = new XMLHttpRequest();
    var com = 'tran';
    var user = getCookie("Id");
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

   var pozDate = [];
    var pozId = [];
    var negDate = [];
    var negId = [];

    for(i=0; i< obj.length;i++){
        if(obj[i].Value > 0)
        {
          
            pozDate.push(obj[i].TranDate);
            pozId.push(obj[i].UserId);
            
        }
        else if(obj[i].Value < 0){
          
            negDate.push(obj[i].TranDate);
            negId.push(obj[i].UserId);
        }
    }

    var sumDates = pozDate.concat(negDate);
    var sumUserId = pozId.concat(negId);

    var deleteObjects = document.getElementsByName("deletee");
    

       for(i=0; i< obj.length;i++){
        if (deleteObjects[i].checked == true)
        {
            var xmlhttp = new XMLHttpRequest();
            var uId = sumUserId[i];
            var time = sumDates[i];
            xmlhttp.open("DELETE", "phpApi.php", false);
            xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        
            xmlhttp.onload = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
                    alert(xmlhttp.status_message);
                } else {
                    
                }
            }
        
            xmlhttp.send(JSON.stringify(
                { 
            "com" : com,
            "uId" : uId,
            "time" : "'"+time+"'",
            "token" : token
            }));
        }


      }

    }
    alert("Tranzakció sikeresen törölve!");
    request.send()
    window.onload();

}
function tranMod(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("PUT", "phpApi.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xmlhttp.onload = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
            alert(xmlhttp.status_message);
        } else {
            
        }
    }
    var time = "'2020-01-19 18:36:41'";
    

    var token = getCookie("Token");
    xmlhttp.send(JSON.stringify(
        { 
    "com" : 'tran',
    "Value" : 200,
   "TranCatId" : 'null',
    "Personal" : 'null',
    "uid" : 9,
    "time" :  time,
    "token" : token


    }));


alert('siker');
window.onload();

}
function updateTransaction(){
    var request = new XMLHttpRequest();
    var com = 'tran';
    var user = getCookie("Id");
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

   var pozDate = [];
    var pozId = [];
    var negDate = [];
    var negId = [];

    for(i=0; i< obj.length;i++){
        if(obj[i].Value > 0)
        {
          
            pozDate.push(obj[i].TranDate);
            pozId.push(obj[i].UserId);
            
        }
        else if(obj[i].Value < 0){
          
            negDate.push(obj[i].TranDate);
            negId.push(obj[i].UserId);
        }
    }

    var sumDates = pozDate.concat(negDate);
    var sumUserId = pozId.concat(negId);

    var updateObjects = document.getElementsByName("updatee");
    var el = document.getElementById('getCategories5');
    var x = el.options[el.selectedIndex].value;
    var catArray = x.split(" - ");
    var cat = parseInt(catArray[0]);

    var value = document.getElementById('costUpdate').value;
    

       for(i=0; i< obj.length;i++){
        if (updateObjects[i].checked == true)
        {
            var xmlhttp = new XMLHttpRequest();
            var uid = sumUserId[i];
            var time = sumDates[i];
            xmlhttp.open("PUT", "phpApi.php", false);
            xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        
            xmlhttp.onload = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
                    alert(xmlhttp.status_message);
                } else {
                    
                }
            }
  
            xmlhttp.send(JSON.stringify(
                { 
            "com" : com,
            "Value" : value,
            "TranCatId" : cat,
            "Personal" : personal,
            "uid" : uid,
            "time" : "'"+time+"'",
            "token" : token
            }));
        }


      }

    }
    
    request.send()
    window.onload();

}



function deleteCategory(){
    var xmlhttp = new XMLHttpRequest();
    var com = 'cat';
    var table = 'Categorys';
    var el = document.getElementById('getCategories4');
    var x = el.options[el.selectedIndex].value;
    var catArray = x.split(" - ");
    var id = parseInt(catArray[0]);
    var token = getCookie("Token");
    xmlhttp.open("DELETE", "phpApi.php", false);
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xmlhttp.onload = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
            alert(xmlhttp.status_message);
        } else {
            alert("Kategória sikeresen törölve!");
        }
    }

    xmlhttp.send(JSON.stringify(
        { 
    "com" : com,
    "table" : table,
    "Id" : id,
    "token" : token
    }));
}




