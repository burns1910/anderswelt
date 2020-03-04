<?php

include 'model/ResetToken.php';

class ResetDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function getResetTokenByMail($email) {
    try {
      $query = $this->connection->prepare("SELECT * FROM pw_reset WHERE EMAIL=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "ResetToken");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function getTokenBySelector($selector) {
    try {
      $query = $this->connection->prepare("SELECT * FROM pw_reset WHERE SELECTOR=:selector");
      $query->bindParam("selector", $selector, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "ResetToken");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function addToken($email, $selector, $token, $token_expire_date) {
    try {
      $query = $this->connection->prepare("INSERT INTO pw_reset(EMAIL,SELECTOR,TOKEN,TOKEN_EXPIRE_DATE) VALUES (:email,:selector,:token,:token_expire_date)");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->bindParam("selector", $selector, PDO::PARAM_STR);
      $query->bindParam("token", $token, PDO::PARAM_STR);
      $query->bindParam("token_expire_date", $token_expire_date, PDO::PARAM_STR);
      $query->execute();
      $id = $this->connection->lastInsertID();
      return $id;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function deleteTokenByEMail($email) {
    try {
      $query = $this->connection->prepare("DELETE FROM pw_reset WHERE email=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      $deleted = $query->rowCount();
      return $deleted;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

//TODO: Hilfsmethoden in Service Layer implementieren
  public function isTokenExpired($token) {
      $expired = true;
      $expireDate = strtotime($token->getTokenExpireDate());
      $timestamp = time();

      if($timestamp >= $expireDate) {
          $_SESSION['error_msg'] = 'Der Link zur Verifizierung ist abgelaufen.';
      } elseif ($timestamp < $expireDate) {
          $expired = false;
      }
      return $expired;
  }

  public function isTokenValid($selector, $validator) {
      // Get tokens
      $result = $this->getTokenBySelector($selector);
      if ( !empty( $result ) ) {
          $token = $result->getToken();
          $calc = hash('sha256', hex2bin($validator));

          // Validate tokens
          if ( hash_equals( $calc, $token ) )  {
              return true;
          }
          else {
              $_SESSION['error_msg'] = 'Verifizierung fehlgeschlagen.';
              return false;
          }
      }
      else {
          $_SESSION['error_msg'] = 'Verifizierung fehlgeschlagen.';
          return false;
      }
  }

}
