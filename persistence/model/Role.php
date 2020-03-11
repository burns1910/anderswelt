<?php
class Role {

/*----------- Properties ----------------*/

  private $id;
  private $name;
  private $description;
  private $permissions;

/*----------- Getters ----------------*/

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getPermissions() {
    return $this->permissions;
  }

/*----------- Setters ----------------*/

  public function setName($name) {
    $this->name = $name;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function setPermission($permission) {
    $this->permissions[] = $permission;
  }

  public function removePermission($permission) {
    $key = array_search($permission, $this->permissions);
    unset($this->permissions[$key]);
  }

}

?>
