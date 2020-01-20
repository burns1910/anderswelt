<?php
include 'gl_controller.php';

if (isset($_POST['add-gl'])) {
 
    $name = $_POST['name'];
    $type = $_POST['type'];
    $plus = $_POST['plus'];
    $va_id = $_POST['va_id'];

    $gl_id = addGLPlatz($va_id, $name, $plus, $type);
        if($gl_id!=0) {
            $message = '<p class="aw-success-message">'.$name.' wurde erfolgreich zur Liste hinzugefügt.</p><br />';
        } else {
            $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
        }
}

if (isset($_POST['edit-gl'])) {
    $id = $_POST['id'];
 
    $name = $_POST['name'];
    $plus = $_POST['plus'];
    $type = $_POST['type'];

    $updated = updateGLPlatz($id, $name, $plus, $type);
    if($updated) {
        $message = '<p class="aw-success-message">Daten f&uuml;r '.$name.' wurden erfolgreich ge&auml;ndert.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Daten konnten nicht aktualisiert werden.</p><br />';
    }
}
?>