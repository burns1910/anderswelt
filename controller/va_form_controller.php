<?php
include 'va_controller.php';

if (isset($_POST['create-va'])) {

    $titel = $_POST['titel'];
    $start_tag = $_POST['start_tag'];
    $start_zeit = $_POST['start_zeit'];
    $ende_tag = $_POST['ende_tag'];
    $ende_zeit = $_POST['ende_zeit'];

    $timestamp_start = strtotime($start_tag.$start_zeit);
    $timestamp_ende = strtotime($ende_tag.$ende_zeit);
    $start = date('Y-m-d H:i:s',$timestamp_start);
    $ende = date('Y-m-d H:i:s',$timestamp_ende);

    $va_id = addVeranstaltung($titel, $start, $ende);

    if ($va_id !=0) {
        $_SESSION['success_msg'] = 'Veranstaltung "'.$titel.' "wurde erfolgreich erstellt';
    } else {
        $_SESSION['error_msg'] = 'Veranstaltung konnte nicht erstellt werden.';
    }

}
?>
