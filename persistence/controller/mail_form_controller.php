<?php
include 'mail_controller.php';

if (isset($_POST['send-mail-to-lists'])) {
 
    $absender_name = $_POST['absender-name'];
    $absender_adresse = $_POST['absender-adresse'];
    isset($_POST['listen']) ? $empfaenger_listen = $_POST['listen'] : $empfaenger_listen = array();
    isset($_POST['crew_member']) ? $empfaenger_personen = $_POST['crew_member'] : $empfaenger_personen = array();
    $betreff = $_POST['betreff'];
    $text = $_POST['text'];

    //TODO: Validation
    $alleAdressen = getAllMailsFromLists($empfaenger_listen, $empfaenger_personen);
    #var_dump($alleAdressen);

    if(($_FILES['datei']['name'] != "")) {
	    $upload_folder = 'upload/'; //Das Upload-Verzeichnis
	    $filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME);
	    $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));
	     	     
	    //Überprüfung der Dateigröße
	    $max_size = 5*1024*1024; //5 MB
	    if($_FILES['datei']['size'] > $max_size) {
	     die("Bitte keine Dateien größer 5MB hochladen");
	    }
	     
	    //Pfad zum Upload
	    $new_path = $upload_folder.$filename.'.'.$extension;
	     
	    //Neuer Dateiname falls die Datei bereits existiert
	    if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
	     $id = 1;
	     do {
	     $new_path = $upload_folder.$filename.'_'.$id.'.'.$extension;
	     $id++;
	     } while(file_exists($new_path));
	    }
	     
	    //Alles okay, verschiebe Datei an neuen Pfad
	    move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);

	    $i=0;
	    foreach ($alleAdressen as $adresse) {
	    	sendMailMitAnhang($adresse, $betreff, $text, $absender_adresse, $absender_name, $new_path);
	    	$i++;
	    }
	    $message = '<p class="aw-success-message">E-Mail wurde erfolgreich an '.$i.' Personen gesendet.</p><br />';
	    $message .= '<p class="aw-info-message">Bitte pr&uuml;fe dein Postfach, um zu checken, ob auch alle Mails zugestellt werden konnten.</p><br />';
	    sendMailMitAnhang("burns@anderswe.lt", $betreff, $text, $absender_adresse, $absender_name, $new_path);
	    
    } else {
    	$i=0;
    	foreach ($alleAdressen as $adresse) {
    		sendMail($adresse, $betreff, $text, $absender_adresse, $absender_name);
    		$i++;
    	}
    	$message = '<p class="aw-success-message">E-Mail wurde erfolgreich an '.$i.' Personen gesendet.</p><br />';
	    $message .= '<p class="aw-info-message">Bitte pr&uuml;fe dein Postfach, um zu checken, ob auch alle Mails zugestellt werden konnten.</p><br />';
    	sendMail("burns@anderswe.lt", $betreff, $text, $absender_adresse, $absender_name);
    }
}

?>