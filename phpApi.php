<?php

/*
-Regisztráció (insert) kész
-Login (Select +Session) 
-Tranzakció felvitele (insert) kész
-Kategória felvitele (insert) kész
-Család menedzselése (select, insert) 
-Állandó tranzakciók beállítása (??)
-Költségvetés tételes megjelenítése (select)
-Grafikus megjelenítés (select)
-Csoportos megjelenítés (select)
-Megtakarítási célok kezelése (select. insert)
-tranzakció törlése (delete, userId, TimeStamp)
*/
include("connection.php");
$db = new dbObj(); $connection =  $db->getConnstring();
$request_method=$_SERVER["REQUEST_METHOD"]; //melyik metódussal hívták az API-t?
switch($request_method) {
  case 'GET':
        $response=array(
        'status' => 0,
        'status_message' =>'User Addition Failed.'
        );
      header('Content-Type: application/json');
      echo json_encode($response);
   break;
 case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);
    //echo file_get_contents('php://input');
    /*
    switch ($data['com']){
        case 'user':
            insertUser($data);
        break;
        case 'cat':
            insertCategory($data);
        break;
        case 'tran':
            insertTransaction($data);
        break;
        case 'family':
            insertFamily($data);
        break;
    }*/
    $response=array(
        'status' => 1,
        'status_message' =>'Transaction Added Successfully.'
         );
         header('Content-Type: application/json');
      echo json_encode($response); 
  break;
case 'PUT':
    $data = json_decode(file_get_contents('php://input'), true);
    switch ($data['com']){
        case 'user':
            updateUser($data);
        break;
        case 'cat':
            updateCategory($data);
        break;
        case 'tran':
            updateTransaction($data);
        break;
        case 'fammember':
            updateFamMember($data);
        break;
    }

   break;

 case 'DELETE':
    $data = json_decode(file_get_contents('php://input'), true);
    switch($data['com']){
        case 'tran':
            delTransaction($data);
        break;
        default:
            delete($data);
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
    $Pass = $data['password'];
    echo $query="INSERT INTO User SET   Name ='".$Name."', Mail='".$Mail."', Password='".$Pass."'";
    //echo $query="INSERT INTO 'User' VALUES ('dd', 'ff', 'gg')";
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
      echo json_encode($response); 
}
function insertCategory($data){
    global $connection;
    $Name = $data['name'];
    $creaId = $data['creaId'];
    $global = $data['global'];
    echo $query="INSERT INTO Categorys SET   Name ='".$Name."', CreatorId=".$creaId.", Global=".$global."";
    //echo $query="INSERT INTO 'User' VALUES ('dd', 'ff', 'gg')";
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
    echo $query="INSERT INTO Transactions SET   UserId =".$userId.", TranCatId=".$catId.", Value=".$value.", Personal=".$personal;
    
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

function insertFamily($data){
    global $connection;
    $name = $data['name'];
    $fId = $data['fId'];
    $query="INSERT INTO Family SET   Name ='".$name."', FatherId=".$fId;
    
    if(mysqli_query($connection, $query))   {    
    //    $queryFamId = "SELECT Id FROM Family WHERE FatherId=".$fId." LIMIT 1";
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

function addFamMember($data)
{
    global $connection;
    $uId = $data['uid'];
    $famId = $data['famId'];
    echo $query = "UPDATE User SET FamilyId=".$famId." WHERE Id=".$uId;
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

function delete($data)
{
    global $connection;
    $table = $data['table'];
    $id = $data['Id'];
    echo $query="DELETE FROM ".$table." WHERE Id=".$id;
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
    echo $query="DELETE FROM Transactions WHERE UserId=".$uid." AND TranDate=".$time;
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
function delFamMember($data){
    global $connection;
    $uId = $data['uid'];
    
    echo $query = "UPDATE User SET FamilyId=NULL WHERE Id=".$uId;
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
function updateUser($data){}
function updateCategory($data){}
function updateTransaction($data){}
//alapértelmezetten fél évre tudják lekérni a felhasználók az adatokat, hogy a hálózati forgalom ne nőljön túl nagyra! 
function getPersonTranList($data){
//userId (kötelező)
//kategória (több is lehet)
//value (intervallum)
//idő (intervallum)    
//rendezés 
global $connection;
$personal = $data['personal']
$userId = $data['user'];
$catId = $data['cat'];
$maxVal = $data['maxVal'];
$minVal = $data['minVal'];
$minDat = $data['minDat'];
$maxDat = $data['maxDat'];
$rendezIrany = $data['ir'];
$rendezSzemp = $data['szemp'];
if($personal == 0)
{

}
echo $query = "
    SELECT * FROM Transactions WHERE"+
    "" 
";

}
function getFamilyMemberList($data){}
?>