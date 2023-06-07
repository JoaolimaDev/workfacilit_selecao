<?php

namespace model;
use \PDO;
use PDOException;

class Database {
  // DB Params
 
  private $host = 'jcasolutions.com.br';
  private $db_name = 'jcasolutions_gip2021Admin';
  private $username = 'jcasolutions_gip2021Admin';
  private $password = 'jcasolutions369*';
  private $conn;

  // DB Connect


  public function connect() {
    $this->conn = null;

    try {
      
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
      $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->conn;
  }

  
}

?>