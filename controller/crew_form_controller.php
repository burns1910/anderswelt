<?php
include 'crew_controller.php';
global $crewList;

if (isset($_POST['register-crew-member'])) {
 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $kommentar = $_POST['kommentar'];
    isset($_POST['listen']) ? $listen = $_POST['listen'] : $listen = null;
    $errors = false;

    if(doesCrewMemberExist($email) == true) {
        $message = '<p class="aw-error-message">Diese E-Mail wurde bereits registriert.</p><br />';
        $errors = true;
    }

    if(!$errors) {
        $crew_member_id = addCrewMember($name, $email, $telefon, $kommentar);
        if($crew_member_id!=0) {
            $message = '<p class="aw-success-message">'.$name.' wurde erfolgreich zur Crewliste hinzugefügt.</p><br />';
        } else {
            $message = '<p class="aw-error-message">Crewmember konnte nicht gespeichert werden.</p><br />';
        }
    }

    if ($listen!=null && $crew_member_id!=null) {
        addCrewMemberToLists($crew_member_id, $listen);
    }
}

if (isset($_POST['update-crew-member'])) {
    $crew_member_id = $_POST['crew-member-id'];
 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $kommentar = $_POST['kommentar'];
    isset($_POST['listen']) ? $listen = $_POST['listen'] : $listen = array();

    $updated = updateCrewMember($crew_member_id, $name, $email, $telefon, $kommentar);
    if($updated) {
        $message = '<p class="aw-success-message">Daten f&uuml;r '.$name.' wurden erfolgreich ge&auml;ndert.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Daten konnten nicht aktualisiert werden.</p><br />';
    }

    $original_list = getAllListIDsFromCrewMember($crew_member_id);
    $submitted_list = $listen;

    $delete_list = array_diff($original_list, $listen);
    $insert_list = array_diff($listen, $original_list);

    deleteCrewMemberFromLists($crew_member_id, $delete_list);
    addCrewMemberToLists($crew_member_id, $insert_list);
}

if ((!isset($_GET['filter-liste']) || $_GET['filter-liste'] == 'all') && (!isset($_GET['filter-tag']) || $_GET['filter-tag'] == 'no-tag')) {
    $crewList = listeAllerCrewMember();
} elseif (isset($_GET['filter-liste']) && $_GET['filter-tag'] == 'no-tag') {
    $list_id = $_GET['filter-liste'];
    $crewList = getAllMemberDataFromList($list_id);
} elseif ($_GET['filter-liste'] == 'all' && $_GET['filter-tag'] != 'no-tag') {
    $hashtag = $_GET['filter-tag'];
    $crewList = getAllMemberDataByTag($hashtag);
} else {
    $list_id = $_GET['filter-liste'];
    $hashtag = $_GET['filter-tag'];
    $crewList = getAllMemberDataFromListSortedByHashtag($list_id, $hashtag);    
}
?>