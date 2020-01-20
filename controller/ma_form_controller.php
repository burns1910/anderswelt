<?php
include 'ma_controller.php';

if (isset($_POST['update-ma'])) {
    $id = $_POST['ma-id'];
 
    isset($_POST['cvd']) ? $cvd = $_POST['cvd'] : $cvd = 0;
    isset($_POST['cvt']) ? $cvt = $_POST['cvt'] : $cvt = 0;
    isset($_POST['selector']) ? $selector = $_POST['selector'] : $selector = 0;
    isset($_POST['kasse']) ? $kasse = $_POST['kasse'] : $kasse = 0;
    isset($_POST['tresenmuetze']) ? $tresenmuetze = $_POST['tresenmuetze'] : $tresenmuetze = 0;
    isset($_POST['tresen']) ? $tresen = $_POST['tresen'] : $tresen = 0;
    isset($_POST['runner']) ? $runner = $_POST['runner'] : $runner = 0;
    isset($_POST['garderobe']) ? $garderobe = $_POST['garderobe'] : $garderobe = 0;
    isset($_POST['hofmuetze']) ? $hofmuetze = $_POST['hofmuetze'] : $hofmuetze = 0;
    isset($_POST['hofwache']) ? $hofwache = $_POST['hofwache'] : $hofwache = 0;
    isset($_POST['awareness']) ? $awareness = $_POST['awareness'] : $awareness = 0;
    isset($_POST['hygiene']) ? $hygiene = $_POST['hygiene'] : $hygiene = 0;
 
    //TODO: Validation
    updateMitarbeiterTasks($id, $cvd, $cvt, $selector, $kasse, $tresenmuetze, $tresen, $runner, $garderobe, $hofmuetze, $hofwache, $awareness, $hygiene);
}

if (isset($_GET['edit']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $aktiv = ($_GET['edit']=='aktivieren') ? 1 : 0 ;
 
    activateDeactivateMitarbeiter($id, $aktiv);
}

?>