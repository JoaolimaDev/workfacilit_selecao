<?php
namespace model;
use PDO;

require_once("Database.php");

class Sql{
    
    public static $stmt;
    

  public static function select(string $Raw_Query, array $params = array()) : array
  {

      $database = new Database;

      $conn = $database->connect();

      Sql::$stmt = $conn->prepare($Raw_Query);
      
      Sql::setParams($params);

      Sql::$stmt->execute();
  
      return Sql::$stmt->fetchAll(PDO::FETCH_ASSOC);
      
  }

  public static function query(string $Raw_Query, array $params = array())
  {
   
    $database = new Database;

    $conn = $database->connect();

    Sql::$stmt = $conn->prepare($Raw_Query);
    
    Sql::setParams($params);

    Sql::$stmt->execute();
  }

  private static function setParams($parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			Sql::bindParam($key, $value);

		}

	}

	private static function bindParam($key, $value)
	{

		return Sql::$stmt->bindValue($key, $value);

	}
}
?>
