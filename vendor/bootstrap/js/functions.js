
//'http://localhost/Malacpersely/phpApi.php';
//'http://mrnoobrft.ddns.net/Malacpersely/phpApi.php'

window.onload = function() {
    this.getCategoryList();
    this.getTranList();
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
        } else {
            alert(loginReq.status_message);
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
            document.getElementById("inComeUserId").innerHTML += obj[i].UserId+"<br>";
            document.getElementById("inComeCategory").innerHTML += obj[i].TranCatId+"<br>";
            document.getElementById("inComeValue").innerHTML += obj[i].Value+"<br>";
           document.getElementById("inComeDate").innerHTML += obj[i].TranDate+"<br>";
           document.getElementById("updateTrans").innerHTML += '<input id="' + i + '" type="radio" value="' + i+'" name="updatee"></input>'+"<br>";
            document.getElementById("deleteTrans").innerHTML += '<input id="' + i + '" type="checkbox" value="' + i+'" name="deletee"></input>'+"<br>";
            inOutSum+=parseInt(obj[i].Value);
        }
        else{
        document.getElementById("costId").innerHTML += costId+"<br>";
        costId++;
        document.getElementById("costUserId").innerHTML += obj[i].UserId+"<br>";
        document.getElementById("costCategory").innerHTML += obj[i].TranCatId+"<br>";
        document.getElementById("costValue").innerHTML += obj[i].Value+"<br>";
        document.getElementById("costDate").innerHTML += obj[i].TranDate+"<br>";
        document.getElementById("updateTrans2").innerHTML += '<input id="' + i + '" type="radio" value="' + i+'" name="updatee"> </input>'+"<br>";
        document.getElementById("deleteTrans2").innerHTML += '<input id="' + i + '" type="checkbox" value="' + i+'" name="deletee">  </input>'+"<br>";
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
        document.getElementById("getCategories1").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";
        document.getElementById("getCategories2").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>';
        document.getElementById("getCategories3").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";
        document.getElementById("getCategories4").innerHTML +='<option id="' + i + '">' +obj[i].Id+' - '+obj[i].Name+'</option>'+"<br>";

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
    
    var el = document.getElementById('getCategories3');
    var x = el.options[el.selectedIndex].value;
    var catArray = x.split(" - ");
    var cat = parseInt(catArray[0]);

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
    window.onload();
}

function newCategory(){
    var xmlhttp = new XMLHttpRequest();
    var com = 'cat';
    var name = document.getElementById('inputCategory').value;
   
    var creaId = 9;
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
 
   
    inUserId = document.getElementById("inComeUserId");
    for(var i = 0; i < inUserId.length; i++)
    {
        alert(inUserId[i]);
    }
        
    
    alert(inUserId);


    var deleteObjecjts = document.getElementsByName("deletee");
    var inUserId = document.getElementById("inComeUserId").value;
    var cUserId = document.getElementById("costUserId").value;
    var inTranDate= document.getElementById("inComeDate").value;
    var cTranDate = document.getElementById("costDate").value;

    /*var userSum = inUserId.concat(cUserId);
    var dateSum = inTranDate.concat(cTranDate);

    for(var i = 0; i<deleteObjecjts.length; i++)
    {
        if (deleteObjecjts[i].checked == true)
        {
            alert(dateSum);
            
            
            /*var xmlhttp = new XMLHttpRequest();
            var com = 'tran';
            var token = getCookie("Token");
            xmlhttp.open("DELETE", "phpApi.php", false);
            xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        
            xmlhttp.onload = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == "1") {
                    alert(xmlhttp.status_message);
                } else {
                    alert("Tranzakció sikeresen törölve!");
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

    }*/

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

function send() {
    var genders = document.getElementsByName("gender");
    if (genders[0].checked == true) {
        alert("Your gender is male");
    } else if (genders[1].checked == true) {
        alert("Your gender is female");
    } else {
        // no checked
        var msg = '<span style="color:red;">You must select your gender!</span><br /><br />';
        document.getElementById('msg').innerHTML = msg;
        return false;
    }
    return true;
}

function reset_msg() {
    document.getElementById('msg').innerHTML = '';
}


