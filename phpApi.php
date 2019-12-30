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
    //if(!empty($_GET["id"]))
    switch ($_GET['com']){
        case 'tran':
            getPersonTranList($_GET['user'],$_GET['cat'],$_GET['minVal'],$_GET['maxVal'],$_GET['minDat'],$_GET['maxDat'],$_GET['ir'],$_GET['szemp']);
        break;
        case 'cat':
        break;
        case 'user':
        break;
        case 'family':
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
            insertCategory($data);
        break;
        case 'tran':
            insertTransaction($data);
        break;
        case 'family':
            insertFamily($data);
        break;
    }
    
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
    echo $query="INSERT INTO User SET Name ='".$Name."', Mail='".$Mail."', Password='".$Pass."'";
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
    echo $query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.", Global=".$global;
    //echo $query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.",Global=".$global;
    
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
    //echo $query="INSERT INTO Categorys SET Name ='".$Name."', CreatorId=".$creaId.", Global=".$global;
    echo $query="INSERT INTO Family SET Name ='".$name."', FatherId=".$fId;
    
    if(mysqli_query($connection, $query))   {    
    //    $queryFamId = "SELECT Id FROM Family WHERE FatherId=".$fId." LIMIT 1";
        echo $query = "UPDATE User SET FamilyId=".getFamilyId($fId)." WHERE Id=".$fId;
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
        echo $query = "UPDATE User SET FamilyId=NULL WHERE Id=".$uId;
    }else{
        echo $query = "UPDATE User SET FamilyId=".$famId." WHERE Id=".$uId;
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
function getPersonTranList($userId, $catId, $minVal, $maxVal, $minDat, $maxDat, $rendezIrany, $rendezSzemp){
//userId (kötelező)
//kategória (több is lehet)
//value (intervallum)
//idő (intervallum)    
//rendezés 

    global $connection;
    //$personal = $data['personal'];
    
    //UserId,TranCatId,Value,Personal,TranDate
    $query = "SELECT * FROM Transactions WHERE UserId=".$userId;
    
    $cat = explode('|',$catId);
    if(count($cat)>1){$szuro = " AND";}
    for($i = 0; $i <= count($cat)-1; $i++){
        if($i<count($cat)-1){$szuro = $szuro." TranCatId=".$cat[$i]." OR ";}else{$szuro = $szuro." TranCatId=".$cat[$i];}
    }
    if($minVal != "null"){$szuro = $szuro." AND Value >".$minVal;}
    if($maxVal != "null"){$szuro = $szuro." AND Value <".$maxVal;}
    
    $response=array();
    $query = $query.$szuro;
    $result=mysqli_query($connection, $query);
    //$result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result))  {
        $response[]=$row;
    }
    
    header('Content-Type: application/json'); //header
    echo json_encode($response); //in JSON format }
    //echo json_encode($cat);
    //echo json_encode($query); //in JSON format }
    
}
function getFamilyMemberList($data){}
?>