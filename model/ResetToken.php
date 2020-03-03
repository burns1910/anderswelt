<?php
class ResetToken {

/*----------- Properties ----------------*/

  private $id;
  private $email;
  private $selector;
  private $token;
  private $token_expire_date;

/*----------- Getters ----------------*/

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getSelector() {
    return $this->selector;
  }

  public function getToken() {
    return $this->token;
  }

  public function getTokenExpireDate() {
    return $this->token_expire_date;
  }

/*----------- Setters ----------------*/

  public function setEmail($email) {
    $this->email = $email;
  }

  public function setSekector($selector) {
    $this->token = $selector;
  }

  public function setToken($token) {
    $this->token = $token;
  }

  public function setTokenExpireDate($token_expire_date) {
    $this->token_expire_date = $token_expire_date;
  }

}
?>
