<?php

class Database {

  private $host;
  private $user;
  private $password;
  private $database;
  private $connection;

  function __construct($host, $user, $password, $database) {
    $this->host = $host;
    $this->user = $user;
    $this->password = $password;
    $this->database = $database;
    $this->connection = NULL;
  }

  public function getConnection() {
    if(is_null($this->connection)) {
      try {
        $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->user, $this->password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
      }
    }
    return $this->connection;
  }

}

?>
