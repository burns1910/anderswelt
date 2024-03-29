<?php
class Permission implements JsonSerializable {

/*----------- Properties ----------------*/

  private $id;
  private $name;
  private $description;

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

/*----------- Setters ----------------*/

  public function setVorname($name) {
    $this->name = $name;
  }

  public function setNachname($description) {
    $this->description = $description;
  }

/*----------- JsonSerializable ----------------*/

  public function jsonSerialize()
  {
      return
      [
          'id'   => $this->getId(),
          'name' => $this->getName(),
          'description' => $this->getDescription()
      ];
  }

}
?>
