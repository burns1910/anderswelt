<?php
class Veranstaltung implements JsonSerializable {

/*----------- Properties ----------------*/

  private $id;
  private $titel;
  private $start;
  private $ende;
  private $header;

/*----------- Getters ----------------*/

  public function getId() {
    return $this->id;
  }

  public function getTitel() {
    return $this->titel;
  }

  public function getStart() {
    return $this->start;
  }

  public function getEnde() {
    return $this->ende;
  }

  public function getHeader() {
    return $this->header;
  }

/*----------- Setters ----------------*/

  public function setTitel($titel) {
    $this->titel = $titel;
  }

  public function setStart($start) {
    $this->start = $start;
  }

  public function setEnde($ende) {
    $this->ende = $ende;
  }

  public function setHeader($header) {
    $this->header = $header;
  }

  /*----------- JsonSerializable ----------------*/

  public function jsonSerialize()
    {
        return
        [
            'id'   => $this->getId(),
            'titel' => $this->getTitel(),
            'start' => $this->getStart(),
            'ende' => $this->getEnde(),
            'header' => $this->getHeader()
        ];
    }

}

?>
