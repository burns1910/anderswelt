<?php

include BASE_PATH.'/persistence/model/Veranstaltung.php';

class VeranstaltungDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function addVeranstaltung($titel, $start, $ende, $header) {
    try {
      $query = $this->connection->prepare("INSERT INTO veranstaltung(TITEL, START, ENDE, HEADER) VALUES (:titel,:start,:ende, :header)");
      $query->bindParam("titel", $titel, PDO::PARAM_STR);
      $query->bindParam("start", $start, PDO::PARAM_STR);
      $query->bindParam("ende", $ende, PDO::PARAM_STR);
      $query->bindParam("header", $header, PDO::PARAM_STR);
      $query->execute();
      $id = $this->connection->lastInsertID();
      return $id;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function getAnstehendeVA() {
    $retval = null;
    try {
      $query = $this->connection->prepare("SELECT * FROM veranstaltung WHERE ende>NOW()");
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "Veranstaltung");
      $i = 0;
      while($result = $query->fetch()) {
          $retval[$i] = $result;
          $i++;
      }
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  return $retval;
  }

  public function getVAByID($id) {
    try {
      $query = $this->connection->prepare("SELECT * FROM veranstaltung WHERE ID=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "Veranstaltung");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

}
