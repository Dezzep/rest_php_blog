<?php 
 // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


  // if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  //   header("Access-Control-Allow-Origin: *");
  //   header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  //   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  //   http_response_code(200);
  //   exit;}
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  
  // Set ID to update
  $post->id = $data->id;
  $post->title = $data->title;
  $post->body = $data->body;
  $post->author = $data->author;
  $post->category_id = $data->category_id;

  // Update post
  if($post->update()) {
    echo json_encode(
      array('message' => 'Post Updated', 'id' => $post->id, 'title' => $post->title, 'body' => $post->body, 'author' => $post->author, 'category_id' => $post->category_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }
?>
