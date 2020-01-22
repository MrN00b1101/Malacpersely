<?php
require 'jwt.php';

/*
-Regisztráció (insert) kész
-Login (Select +Session) 
-Tranzakció felvitele (insert) kész
-Kategória felvitele (insert) kész
-Család menedzselése (SELECT, insert) 
-Állandó tranzakciók beállítása (??)
-Költségvetés tételes megjelenítése (SELECT) kész
-Megtakarítási célok kezelése (SELECT. insert)
-tranzakció törlése (delete, userId, TimeStamp)kész
-savings létrehozása!
-savings lekérdezése!
-
*/
include("connection.php");
$db = new dbObj(); $connection =  $db->getConnstring();
$request_method=$_SERVER["REQUEST_METHOD"]; //melyik metódussal hívták az API-t?
switch($request_method) {
  case 'GET':
    switch ($_GET['com']){
        case 'tran':
            if(isLogged($_GET['token'])){

                getPersonTranList($_GET['user'],$_GET['cat'],$_GET['minVal'],$_GET['maxVal'],$_GET['minDat'],$_GET['maxDat'],$_GET['personal']);
            }else{
                header("HTTP/1.1 401 Need to login");
            }
        break;
        case 'cat':
            if(isLogged($_GET['token'])){
                getCategoryList($_GET['user'],$_GET['fam']);
            }else{
                header("HTTP/1.1 401 Need to login");
            }
        break;
        case 'user':
            getUserList();
        break;
        case 'family':
            getFamilyList();
        break;
        case 'famMem':
            if(isLogged($_GET['token'])){
                getFamilyMemberList($_GET['famId'],true);
            }else{
                header("HTTP/1.1 401 Need to login");
            }    
        break;
        case 'SpecUser':
            getUser($_GET['Uid'], $_GET['attributum']);
        break;
        case 'logout':
           
                logout();
            
        break;
    } 
   break;
 case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);
    //echo file_get_contents('php://input');
    
    switch ($data['com']){
        case 'user':
            insertUser($data);
        break;
        case 'cat':
            if(isLogged($data['token'])){
                insertCategory($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'tran':
            if(isLogged($data['token'])){
                insertTransaction($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'family':
            if(isLogged($data['token'])){
                insertFamily($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'saving':
            if(isLogged($data['token'])){
                insertSaving($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'login':
            login($data);
        break;
    }
    
  break;
case 'PUT':
    $data = json_decode(file_get_contents('php://input'), true);
    switch ($data['com']){
        case 'user':
            if(isLogged($data['token'])){
                updateUser($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'cat':
            if(isLogged($data['token'])){
                updateCategory($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'tran':
            if(isLogged($data['token'])){
                updateTransaction($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        case 'fammember':
            if(isLogged($data['token'])){
                updateFamMember($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
    }

   break;

 case 'DELETE':
    $data = json_decode(file_get_contents('php://input'), true);
    switch($data['com']){
        case 'tran':
            if(isLogged($data['token'])){
                delTransaction($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
        default:
            if(isLogged($data['token'])){
                delete($data);
            }else{
                header("HTTP/1.1 401 Need to login");
            }  
        break;
    }
    

    break;

default:
    header("HTTP/1.1 405 Method Not Allowed");
    break;
}
function insertUser($data){
    global $connection;
    $Name = $data['name'];
    $Mail = $data['mail'];
    $Pass = md5($data['password']);
    $query="INSERT INTO User SET Name ='".$Name."', Mail='".$Mail."', Password='".$Pass."'";
    header('Content-Type: application/json');
     echo ($query+"    "+$data['password']);
    //$query="INSERT INTO 'User' VALUES ('dd', 'ff', 'gg')";
    if(mysqli_query($connection, $query))   {
        
         $response=array(
               'status' => 1,
               'status_message' =>'User Added Successfully.'
                );
      }
      else     {
         $response=array(
               'status' => 0,
               'status_message' =>'User Addition Failed.'
               );
      }   
      header('Content-Type: application/json');
     echo ($query+"    "+$data['password']);
      // echo json_encode($response); 
}

function insertCategory($data){
    global $connection;
    $Name = $data['name'];
    $creaId = $data['creaId'];
    $global = $data['global'];
    $query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.", Global=".$global;
    //$query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.",Global=".$global;
    
    if(mysqli_query($connection, $query))   {
         $response=array(
               'status' => 1,
               'status_message' =>'Category Added Successfully.'
                );
      }
      else     {
         $response=array(
               'status' => 0,
               'status_message' =>'Category Addition Failed.'
               );
      }   
      header('Content-Type: application/json');
      echo json_encode($response); 
}
function insertTransaction($data){
    global $connection;
    $userId = $data['uId'];
    $catId = $data['catId'];
    $value = $data['value'];
    $personal = $data['personal'];
    $query="INSERT INTO Transactions SET   UserId =".$userId.", TranCatId=".$catId.", Value=".$value.", Personal=".$personal;
    
    if(mysqli_query($connection, $query))   {
         $response=array(
               'status' => 1,
               'status_message' =>'Transaction Added Successfully.'
                );
      }
      else     {
         $response=array(
               'status' => 0,
               'status_message' =>'Transaction Addition Failed.'
               );
      }   
      header('Content-Type: application/json');
      echo json_encode($response);
}
function getFamilyId($fatherId){
    global $connection;
    $query ="SELECT Id FROM Family WHERE FatherId=".$fatherId." LIMIT 1";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($result)){return $row[0];}
    return null;
}

function insertFamily($data){
    global $connection;
    $name = $data['name'];
    $fId = $data['fId'];
    //$query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.", Global=".$global;
    $query="INSERT INTO Family SET Name ='".$name."', FatherId=".$fId;
    
    if(mysqli_query($connection, $query))   {    
    //    $queryFamId = "SELECT Id FROM Family WHERE FatherId=".$fId." LIMIT 1";
        $query = "UPDATE User SET FamilyId=".getFamilyId($fId)." WHERE Id=".$fId;
        if(mysqli_query($connection, $query))   {}
        else     {
            $response=array(
                'status' => 0,
                'status_message' =>'Family (update-nál) Addition Failed.'
                );
        }

        $response=array(
           'status' => 1,
           'status_message' =>'Family Added Successfully.'
                );
         
      }
      else     {
         $response=array(
               'status' => 0,
               'status_message' =>'Family Addition Failed.'
               );
      }   
      header('Content-Type: application/json');
      echo json_encode($response); 
}

function updateFamMember($data)
{
    global $connection;
    $uId = $data['uId'];
    $famId = $data['famId'];
    if($famId == 0)
    {
        $query = "UPDATE User SET FamilyId=NULL WHERE Id=".$uId;
    }else{
        $query = "UPDATE User SET FamilyId=".$famId." WHERE Id=".$uId;
    }
    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'Family Member Addition Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'Family Member Addition Failed.'
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($response);
}

function delete($data)
{
    global $connection;
    $table = $data['table'];
    $id = $data['Id'];
    $query="DELETE FROM ".$table." WHERE Id=".$id;
    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'Deleted Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'Deleted Failed.'
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($response);

}
function delTransaction($data){
    global $connection;
    $uid = $data['uId'];
    $time = $data['time'];
    $query="DELETE FROM Transactions WHERE UserId=".$uid." AND TranDate=".$time;
    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'Deleted Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'Deleted Failed.'.$uid.':::'.$time.":::".$query
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($response);
}

function delFamMember($data){
    global $connection;
    $uId = $data['uid'];
    
    $query = "UPDATE User SET FamilyId=NULL WHERE Id=".$uId;
    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'Deleted Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'Deleted Failed.'
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($response);
}
function updateUser($data){
    global $connection;
    $set = "SET";
    if($data['Name'] != "null"){
        $set = $set." Name=".$data['Name']; 
        if(( $data['Mail'] != "null") || ($data['Pass'] != "null")){$set = $set.",";}
    }
    if($data['Mail'] != "null"){
        $set = $set." Mail=".$data['Mail'];
        if($data['Pass'] != "null"){$set = $set.",";}
    }
    if($data['Pass'] != "null"){$set = $set." Password=".$data['Pass']; }
    $query = "UPDATE User ".$set." WHERE Id=".$data['userId'];
    
    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'User Modification Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'User Modification Failed.'
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($response);
}
function updateCategory($data){
    global $connection;
    $set = "SET";
    if($data['Name'] != "null"){
        $set = $set." Name=".$data['Name']; 
        if($data['Global'] != "null"){$set = $set.",";}
    }
    if($data['Global'] != "null"){
        $set = $set." Global=".$data['Global'];
    }
    $query = "UPDATE Categorys ".$set." WHERE Id=".$data['catId'];
    
    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'Category Modification Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'Category Modification Failed.'
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($response);
}
function updateTransaction($data){
    global $connection;
    $set = "SET";
    if($data['Value'] != "null"){
        $set = $set." Value=".$data['Value']; 
        if(( $data['TranCatId'] != "null") || ($data['Personal'] != "null")){$set = $set.",";}
    }
    if($data['TranCatId'] != "null"){
        $set = $set." TranCatId=".$data['TranCatId'];
        if($data['Personal'] != "null"){$set = $set.",";}
    }
    if($data['Personal'] != "null"){$set = $set." Personal=".$data['Personal']; }
    $query = "UPDATE Transactions ".$set." WHERE UserId=".$data['uid']." AND TranDate=".$data['time'];
    

    if(mysqli_query($connection, $query))   {
        $response=array(
              'status' => 1,
              'status_message' =>'Transaction Modification Successfully.'
               );
     }
     else     {
        $response=array(
              'status' => 0,
              'status_message' =>'Transaction Modification Failed.'
              );
     }   
     header('Content-Type: application/json');
     echo json_encode($query); 
    // echo json_encode($response);
      
}
function getSaving($data, $html){
    global $connection;
    $query = "SELECT * FROM Savings WHERE Id=".$data;
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    if(!$http){return $response;}else{
        header('Content-Type: application/json'); 
        echo json_encode($response); 
        //echo json_encode($query); 
    } 
}
function insertSaving($data){
    //Name;Destination;DesDate;CreatorId;Personal
    global $connection;
    $Name = $data['name'];
    $destination = $data['DesVal'];
    $DesDate = $data['DesDat'];
    $creatorId = $data['creaId'];
    $Personal = $data['per'];
    $query="INSERT INTO Savings SET Name ='".$Name."', Destination=".$destination.", DesDate=".$DesDate.", CreatorId= ".$creatorId.", Personal=".$Personal;
    //$query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.",Global=".$global;
    if(mysqli_query($connection, $query))   {
         $response=array(
               'status' => 1,
               'status_message' =>'Savings Added Successfully.'
                );
      }
      else     {
         $response=array(
               'status' => 0,
               'status_message' =>'Savings Addition Failed.'
               );
      }   
      header('Content-Type: application/json');
      echo json_encode($query); 

      //echo json_encode($response); 

}
function getPersonTranList($userId, $catId, $minVal, $maxVal, $minDat, $maxDat, $personal){
   //Select Savings.Name, User.Name,Categorys.Name, Transactions.* FROM Transactions INNER JOIN Savings on Transactions.Personal = Savings.Id INNER JOIN User on Transactions.UserId = User.Id INNER JOIN Categorys on Transactions.TranCatId = Categorys.Id 

    global $connection;
    //UserId,TranCatId,Value,Personal,TranDate
    if($personal == "-1"){
      //  $uId[0] = $userId;
        $per = -1;
    }else if($personal == "0"){
        $familyMembers = getFamilyMemberList(getFamilyId($userId),false);
       // $uId = array_column($familyMembers,'Id');
        $per = 0;
    }else{
        $familyMembers = getFamilyMemberList(getFamilyId($userId),false);
        //$uId = array_column($familyMembers,'Id');
        $per = $personal;
    }
        $query = "SELECT Savings.Name as 'Savings', User.Name as 'User' ,Categorys.Name as 'Category', Transactions.*  FROM Transactions INNER JOIN Savings on Transactions.Personal = Savings.Id INNER JOIN User on Transactions.UserId = User.Id INNER JOIN Categorys on Transactions.TranCatId = Categorys.Id WHERE Transactions.UserId= ".$userId." AND  Transactions.personal = ".$per;
        /*
        if(count($uId)>0){$szuro = " AND (";}
        for($i = 0; $i <= count($uId)-1; $i++){
            if($i<count($uId)-1){$szuro = $szuro." Transactions.UserId=".$uId[$i]." OR ";}else{$szuro = $szuro." Transactions.UserId=".$uId[$i].")";}
        }
        */
       
        if($catId != "null"){
            $cat = explode('|',$catId);
            if(count($cat)>0){$szuro = $szuro." AND (";}
            for($i = 0; $i <= count($cat)-1; $i++){
                if($i<count($cat)-1){$szuro = $szuro." Transactions.TranCatId=".$cat[$i]." OR ";}else{$szuro = $szuro." Transactions.TranCatId=".$cat[$i].")";}
            }
        }
        if($minVal != "null" || $maxVal != "null"){
            $szuro = $szuro." AND (";
            if($minVal != "null"){$szuro = $szuro."Transactions.Value >".$minVal;}
            if($maxVal != "null"){$szuro = $szuro." AND Transactions.Value <".$maxVal;}
            $szuro = $szuro." )";
        }

        if($minDat != "null" || $maxDat != "null"){
            $szuro = $szuro." AND (";
            if($minDat != "null"){$szuro = $szuro." Transactions.TranDate >".$minDat;}
            if($maxDat != "null"){$szuro = $szuro."AND Transactions.TranDate <".$maxDat;}
            $szuro = $szuro." )";
        }
        $response=array();
        $query = $query.$szuro;
        $result=mysqli_query($connection, $query);
            while($row=mysqli_fetch_array($result))  {
            $response[]=$row;
        }
    
    header('Content-Type: application/json'); 
    //echo json_encode($query); 
    echo json_encode($response); 
    
}

function getFamilyMemberList($famId, $http)
{
    global $connection;
    $query ="SELECT Id, Name FROM User WHERE FamilyId=".$famId;
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    if(!$http){return $response;}else{
        header('Content-Type: application/json'); 
        echo json_encode($response); 
        //echo json_encode($query); 
    } 
}
function getCategoryList($userid, $fam){
    //kellenek a globalok és vagy a personalok, vagy a családiak!
    global $connection;
    //SELECT User.Name as 'User',Categorys.* FROM Categorys INNER JOIN User ON Categorys.CreatorId = User.Id
    if($fam == '0'){
        $familyMembers = getFamilyMemberList(getFamilyId($userid),false);
        $uId = array_column($familyMembers,'Id');
        $query = "SELECT User.Name as 'User',Categorys.* FROM Categorys INNER JOIN User ON Categorys.CreatorId = User.Id WHERE CreatorId = ".$userid;

       /* for ($i=1; $i<=count($uId)-1; $i++){
            $query = $query." OR CreatorId=".$uId[$i];
        }
        $query =  $query."))";*/
    }else{
        $query = "SELECT User.Name as 'User',Categorys.* FROM Categorys INNER JOIN User ON Categorys.CreatorId = User.Id WHERE Global=0 OR CreatorId=".$uid;
    }
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    header('Content-Type: application/json'); 
        echo json_encode($response); 
        //echo json_encode($query); 
}
function getUserList(){
    global $connection;
    $query = "SELECT Id, Name, Mail, FamilyId FROM User";
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    header('Content-Type: application/json'); 
    echo json_encode($response); 
        //echo json_encode($query); 
}
function getFamilyList(){
    global $connection;
    $query = "SELECT * FROM Family";
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    header('Content-Type: application/json'); 
    echo json_encode($response); 
        //echo json_encode($query); //in 
}
function getUser($data, $type){
    global $connection;
    $query = "SELECT Name, Id, FamilyId, Mail FROM Users WHERE ".$type."=".$data;
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    if(!$http){return $response;}else{
        header('Content-Type: application/json'); 
        echo json_encode($response); 
        //echo json_encode($query); 
    } 
}
function logout()
{
    
    setcookie("Token", "", time() - 3600);
    setcookie("User", "", time()-3600);
    setcookie("Id", "", time()-3600);
    header('Content-Type: application/json'); 
    echo json_encode("logged out"); 
  
}
function login($data){
    global $connection;
    $name = $data['Name'];
    $password = $data['password'];
    $secret_key = 'some_test_key';
    $valid_for = '3600';
    $query ="SELECT Name, Id, FamilyId, Mail FROM User WHERE Name='".$name."' AND Password ='".md5($password)."'";
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    
    if(count($response) == 1){
        $token = array();
            $token['id'] = $response[0]['Name'];
            $token['Name'] = $response[0]['Name'];
            $token['Mail'] = $response[0]['Mail'];
            $token['FamId'] = $response[0]['FamilyId'];
            $token['exp'] = time() + $valid_for;
            setcookie("Token", JWT::encode($token, $secret_key), time()+3600);
            setcookie("User", $response[0]['Name'], time()+3600);
            setcookie("Id", $response[0]['Id'], time()+3600);
    /*    $_SESSION['UserId']=$response[0]['Id'];
        $_SESSION['Name']=$response[0]['Name'];
        $_SESSION['Mail']=$response[0]['Mail'];
        $_SESSION['FamId']=$response[0]['FamilyId'];  */
    }else{        
        $response=array(
            'status' => 0,
            'status_message' =>'Login Failed.'
            );
            
    }
    header('Content-Type: application/json'); 
    echo json_encode($response);        
}
function isLogged($token){
    $secret_key = 'some_test_key';
try{
    $user = JWT::decode($token, $secret_key);
    if ($user->exp >= time()) {
        return true;
    } else {
        return false;
    }
}catch(Exception $e){return false;}
}
?>
