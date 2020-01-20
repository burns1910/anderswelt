<?php
include 'list_controller.php';

if (isset($_POST['add-crew-liste'])) {
 
    $name = $_POST['name'];
    $beschreibung = $_POST['beschreibung'];
    isset($_POST['crew_member']) ? $crew_member = $_POST['crew_member'] : $crew_member = null;

    $list_id = addListe($name, $beschreibung);

    if($list_id!=0) {
        $message = '<p class="aw-success-message">Liste '.$name.' wurde erfolgreich erstellt</p><br />';
        if($list_id!=null) {
            addCrewMembersToList($crew_member, $list_id);
        }
    } else {
        $message = '<p class="aw-error-message">Liste '.$name.' konnte nicht erstellt werden.</p><br />';
    }
}

if (isset($_POST['edit-crew-liste'])) {
    $list_id = $_POST['list-id'];
 
    $name = $_POST['name'];
    $beschreibung = $_POST['beschreibung'];
    isset($_POST['crew_member']) ? $crew_member = $_POST['crew_member'] : $crew_member = array();

    $updated = updateListe($list_id, $name, $beschreibung);

    if($updated) {
        $message = '<p class="aw-success-message">Daten f&uuml;r die Liste "'.$name.'"" wurden erfolgreich ge&auml;ndert.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Daten konnten nicht aktualisiert werden.</p><br />';
    }

    $original_list = getAllMemberIDsFromList($list_id);
    $submitted_list = $crew_member;

    $delete_list = array_diff($original_list, $crew_member);
    $insert_list = array_diff($crew_member, $original_list);

    deleteCrewMembersFromList($delete_list, $list_id);
    addCrewMembersToList($insert_list, $list_id);

}

?>