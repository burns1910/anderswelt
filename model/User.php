<?php
class User {

/*----------- Properties ----------------*/

  private $id;
  private $role_id;
  private $vorname;
  private $nachname;
  private $email;
  private $token;
  private $pw_hash;
  private $aktiv;
  private $mail_verified;
  private $token_expire_date;

/*----------- Getters ----------------*/

  public function getId() {
    return $this->id;
  }

  public function getRoleId() {
    return $this->role_id;
  }

  public function getVorname() {
    return $this->vorname;
  }

  public function getNachname() {
    return $this->nachname;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getToken() {
    return $this->token;
  }

  public function getPW() {
    return $this->pw_hash;
  }

  public function isActive() {
    return $this->aktiv;
  }

  public function isMailVerified() {
    return $this->mail_verified;
  }

  public function getTokenExpireDate() {
    return $this->token_expire_date;
  }

/*----------- Setters ----------------*/

  public function setRoleId($role_id) {
    $this->role_id = $role_id;
  }

  public function setVorname($vorname) {
    $this->vorname = $vorname;
  }

  public function setNachname($nachname) {
    $this->nachname = $nachname;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function setToken($token) {
    $this->token = $token;
  }

  public function setPW($pw) {
    $this->pw_hash = $pw;
  }

  public function activate() {
    $this->aktiv = 1;
  }

  public function verifyMail() {
    $this->mail_verified = 1;
  }

  public function setTokenExpireDate($token_expire_date) {
    $this->token_expire_date = $token_expire_date;
  }

}
?>
