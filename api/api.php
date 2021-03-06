<?php

require_once "database.php";
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
    if ($operation=="getVotes"){
      $db=new dbConnect();
      $voteCount = $db->getVoteCount();
      $reply['extend']=$voteCount['extend'];
      $reply['dontextend']=$voteCount['dontextend'];
      $reply["status"]="OK";
    } 

    break;

  case 'PUT':
  //nothing
    break;

  case 'POST': 

    //auth
    if ($operation == "login"){
      $usernm=$_POST['username']; 
      $password=$_POST['passwd'];

      if(empty($usernm)||empty($password)){
        break;
      }

      $db=new dbConnect();
      $result = $db->userLogin($usernm, $password);
      $reply['result'] = $result;
      if($result){
        $reply["status"]="OK";
      }

    } else if($operation == "updateVote"){
      $vote = $_POST['vote'];
      $usernm=$_POST['username']; 
      if (empty($vote))break;
      $result= $db->vote($usernm, $vote);
      $reply["status"]="OK";
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

print json_encode($reply);

?>