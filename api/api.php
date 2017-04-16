<?php

require_once "dbConnect.php";
header('Content-Type: application/json');

# http://stackoverflow.com/questions/797834/should-a-restful-put-operation-return-something
# https://tools.ietf.org/html/rfc7231#section-4.3

$method = $_SERVER['REQUEST_METHOD'];


$reply = array();

$reply["status"]="BAD"; 
$operation = $_REQUEST['operation'];
$db=new dbConnect();

switch ($method) {
  case 'GET':

      //authenticate
    if ($operation=="votes"){

      $usernm = $_REQUEST['username'];
      $passwd = $_REQUEST['password'];
      $passwd=md5($passwd);

      if (authenticate($usernm, $passwd, $db)){

        $reply["status"]="OK";
      }

    } 

    break;

  case 'PUT':
  //nothing
    break;

  case 'POST': 

    //auth
    if ($operation == "login"){
      $usernm=$_POST['username']; 
      $password=$_POST['password'];
      
      $db=new dbConnect();
      $result = $db->userLogin($user, $password);
      
      if($result){
        $reply["status"]="OK";
      } 

    } 

    break;

  case 'DELETE':
  // nothing
  break;

  default:
    // NO Appropriate server request found
    header($_SERVER["SERVER_PROTOCOL"]." 404");

}
if ($reply['status']!="OK"){
  header($_SERVER["SERVER_PROTOCOL"]." 400");
} else {
  header($_SERVER["SERVER_PROTOCOL"]." 200");
}

$reply["post"]=$_POST;
$reply["request"]=$_REQUEST;
print json_encode($reply);

?>