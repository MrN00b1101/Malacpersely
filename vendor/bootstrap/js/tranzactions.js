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

    request.open('GET', 'phpApi.php',true)

    request.onload = function() {
    var obj = JSON.parse(request.response);
    //alert(obj.length);
    
   
    for(i=0; i< obj.length;i++){
       // if(obj[i].Value > 0)
        document.getElementById("inComeValue") +=obj[i].Value;
    }
    //    alert(obj[2].Name);        
        

}
// Send request
request.send()
//alert(getCookie("Token"));
}