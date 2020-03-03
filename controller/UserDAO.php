<?php

include 'model/User.php';

class UserDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function getUserByID($id) {
    try {
      $query = $this->connection->prepare("SELECT * FROM user WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function getUserByEmail($email) {
    try {
      $query = $this->connection->prepare("SELECT * FROM user WHERE email=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function getAllUsers() {
    try {
      $query = $this->connection->prepare("SELECT u.id, u.vorname, u.nachname, u.email, r.name as role FROM user u LEFT JOIN roles r ON u.role_id=r.id");
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      return $obj = $query->fetchAll();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function addUser($vorname, $nachname, $email, $token, $pw_hash, $token_expire_date) {
    try {
      $query = $this->connection->prepare("INSERT INTO user(VORNAME,NACHNAME,EMAIL,TOKEN,PW_HASH,TOKEN_EXPIRE_DATE) VALUES (:vorname,:nachname,:email,:token,:pw_hash,:token_expire_date)");
      $query->bindParam("vorname", $vorname, PDO::PARAM_STR);
      $query->bindParam("nachname", $nachname, PDO::PARAM_STR);
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->bindParam("token", $token, PDO::PARAM_STR);
      $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
      $query->bindParam("token_expire_date", $token_expire_date, PDO::PARAM_STR);
      $query->execute();
      $id = $this->connection->lastInsertID();
      return $id;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  function updateUser($id, $role_id, $vorname, $nachname, $email, $pw_hash) {
    try {
      $query = $this->connection->prepare("UPDATE user SET role_id =:role_id, vorname =:vorname, nachname=:nachname, email=:email, pw_hash=:pw_hash WHERE id = :id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->bindParam("role_id", $role_id, PDO::PARAM_STR);
      $query->bindParam("vorname", $vorname, PDO::PARAM_STR);
      $query->bindParam("nachname", $nachname, PDO::PARAM_STR);
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
      $query->execute();
      $updated = $this->connection->rowCount();
      return $updated;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function deleteUser($id) {
    try {
      $query = $this->connection->prepare("DELETE FROM users WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $deleted = $this->connection->rowCount();
      return $deleted;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function doesUserExist($email) {
    $userExists = false;
    try {
      $query = $this->connection->prepare("SELECT 1 FROM user WHERE EMAIL=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      if(strcmp($query->fetchColumn(), "1") == 0) {
        $userExists = true;
      }
    }
    catch (PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
    return $userExists;
  }

  public function verifyEmail($email) {
    try {
      $query = $this->connection->prepare("UPDATE user SET mail_verified='1' WHERE EMAIL=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
    }
    catch (PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function updatePWByMail($email, $pw_hash) {
    try {
      $query = $this->connection->prepare("UPDATE user SET PW_HASH=:pw_hash WHERE email=:email");
      $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      $updated = $this->connection->rowCount();
      return $updated;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

}

?>
