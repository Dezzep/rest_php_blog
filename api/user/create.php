<?php
  // Headers
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    http_response_code(200);
    exit;
}
  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);


  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $user->username = $data->username;
  $user->password = $data->password;
  $user->email = $data->email;
  $user->first_name = $data->firstname;
  $user->last_name = $data->lastname;

  // Create post
  if($user->create()) {
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Created')
    );
  }

