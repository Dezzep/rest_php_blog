<?php
  // Headers
  header('Access-Control-Allow-Origin: *'); // Allow cross-origin resource sharing (CORS).
  header('Content-Type: application/json'); // Format response as JSON.
  header('Access-Control-Allow-Methods: GET'); // Only allow GET requests.
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With'); // Allow additional headers.

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Check if the ID parameter is there.
  if(!isset($_GET['id'])){
    http_response_code(400);
    echo json_encode(["message"=> "Id not specified"]);
    die();
}// Get ID
  $post->id = isset($_GET['id']) ? $_GET['id'] : die(); // If ID is set, store it in $post->id. Otherwise, stop execution.

  // Get post
  $post->read_single();

  // Create array
  $post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
  );
  // Check if the post actually exists.
  if ($post->title == null) {
    http_response_code(404);
    echo json_encode(["message"=> "Post not found"]);
    die();
  }

  // Make JSON
  print_r(json_encode($post_arr));
?>
