<?php

/*
-Regisztráció (insert)
-Login (Select +Session) 
-Tranzakció felvitele (insert)
-Kategória felvitele (insert)
-Család menedzselése (select, insert)
-Állandó tranzakciók beállítása (??)
-Költségvetés tételes megjelenítése (select)
-Grafikus megjelenítés (select)
-Csoportos megjelenítés (select)
-Megtakarítási célok kezelése (select. insert)
*/
include("../connection.php");
$db = new dbObj(); $connection =  $db->getConnstring();
$request_method=$_SERVER["REQUEST_METHOD"]; //melyik metódussal hívták az API-t?
switch($request_method) {
  case 'GET':
   break;
 case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);
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
        case 'fammember':
            insertFamMember($data);
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
    switch ($data['com']){
        case 'user':
            delUser($data);
        break;
        case 'cat':
            delCategory($data);
        break;
        case 'tran':
            delTransaction($data);
        break;
        case 'fammember':
            delFamMember($data);
        break;
    }

    break;

default:
    header("HTTP/1.1 405 Method Not Allowed");
    break;
}
function insertUser($data){
    global $connection;
    $Name=$data["name"];
    $Mail=$data["mail"];
    $Pass =$data["password"];
    /*echo $query="INSERT INTO User VALUES ('".$Name."', '".$Mail."', '".$Pass."')";
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
      }   */
      $response=array(
        'status' => 0,
        'status_message' =>'User Addition Failed.'
        );
      header('Content-Type: application/json');
      echo json_encode($response); //response with header 
}
function insertCategory(){}
function insertTransaction(){}
function insertFamMemeber(){}

function updateUser(){}
function updateCategory(){}
function updateTransaction(){}
function updateFamMember(){}

function delUser(){}
function delCategory(){}
function delTransaction(){}
function delFamMember(){}

?>