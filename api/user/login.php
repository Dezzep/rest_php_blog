<?php
  // Headers
  header('Access-Control-Allow-Origin: *'); // Allow cross-origin resource sharing (CORS).
  header('Content-Type: application/json'); // Format response as JSON.
  header('Access-Control-Allow-Methods: POST'); // Only allow POST requests.
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With'); // Allow additional headers.

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new User($db);

  // Check if username and password are set.
  if(!isset($_GET['username']) || !isset($_GET['password'])){
    http_response_code(400);
    echo json_encode(["message"=> "Username or Password not specified"]);
    die();
  }
  // Get username and password
  $user->username = isset($_GET['username']) ? $_GET['username'] : die(); // If username is set, store it in $user->username. Otherwise, stop execution.
  $user->password = isset($_GET['password']) ? $_GET['password'] : die(); // If password is set, store it in $user->password. Otherwise, stop execution.

  // Check if credentials are correct.
  $result = $user->login();
  $num = $result->rowCount();
   
  if($num > 0) {
    // User array
    $user_arr = array();
    $user_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $user_item = array(
        'username' => $username,
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name
      );
      // Push to "data"
      array_push($user_arr['data'], $user_item);
    }
    // Turn to JSON & output
    echo json_encode($user_arr);
  } else {
    // Credentials Invalid
    http_response_code(401);

    echo json_encode(
      array('message' => 'No User Found'));
  }
?>
