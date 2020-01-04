
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
            alert(xmlhttp.status_message);
        }
    }

    xmlhttp.send(JSON.stringify(
        { 
    "com": "user",
    "name": document.getElementById("inputUserName").value,
    "mail": document.getElementById("inputEmail").value,
    "pass": document.getElementById("inputPassword").value,
    }));
}