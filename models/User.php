<?php
  class User {
    private $conn;
    private $table = 'users';
    // User Properties

    public $username;
    public $password;
    public $hashedPassword;
    public $email;
    public $first_name;
    public $last_name;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
      
    }

    // Check user login

    public function login() {
      // Create query

      // I added BINARY to the WHERE clause to make the query case-sensitive.
      $query = 'SELECT
        username,
        password,
        email,
        first_name,
        last_name
      FROM
        ' . $this->table . '
      WHERE 
        username = :username AND BINARY password = :password';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->password = htmlspecialchars(strip_tags($this->password));
      

      // Bind data
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':password', $this->password);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Check if username exists

    public function usernameExists() {
      // Create query

      // I added BINARY to the WHERE clause to make the query case-sensitive.
      $query = 'SELECT
        username
      FROM
        ' . $this->table . '
      WHERE BINARY
        username = :username';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->username = htmlspecialchars(strip_tags($this->username));

      // Bind data
      $stmt->bindParam(':username', $this->username);

      // Execute query
      $stmt->execute();

      return $stmt->rowCount() > 0;
    }

    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . '
      SET
        username = :username,
        first_name = :first_name,
        last_name = :last_name,
        email = :email,
        password = :password';
      
       

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->first_name = htmlspecialchars(strip_tags($this->first_name));
      $this->last_name = htmlspecialchars(strip_tags($this->last_name));

      // Bind data
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':first_name', $this->first_name);
      $stmt->bindParam(':last_name', $this->last_name);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
}

?>