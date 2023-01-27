<?php

header('Access-Control-Allow-Origin: *'); // Allow cross-origin resource sharing (CORS).
header('Content-Type: application/json'); // Format response as JSON.
header('Access-Control-Allow-Methods: GET'); // Only allow GET requests.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';
$database = new Database();
$db = $database->connect();

$user = new User($db);

if(!isset($_GET['username'])){
  http_response_code(400);
  echo json_encode(["message"=> "Username not specified"]);
  die();
}

$user->username = isset($_GET['username']) ? $_GET['username'] : die();

$result = $user->usernameExists($user);

if($user->usernameExists()){
  http_response_code(400);
  echo json_encode(["message"=> "Username already taken"]);
  die();
}
else {
  http_response_code(200);
  echo json_encode(["message"=> "Username available"]);
}

?>