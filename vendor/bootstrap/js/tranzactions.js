function getTranList(){
    var request = new XMLHttpRequest();

    request.open('GET', 'phpApi.php',true)

    request.onload = function() {
    var obj = JSON.parse(request.response);
    //alert(obj.length);
    
    document.getElementById("inComeValue").innerHTML = 12;
    for(i=0; i< obj.length;i++){
       // if(obj[i].Value > 0)
        document.getElementById("inComeValue").innerHTML +=obj[i].Value;
    }
    //    alert(obj[2].Name);        
        

}
// Send request
request.send()
//alert(getCookie("Token"));
}