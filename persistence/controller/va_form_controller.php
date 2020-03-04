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

    if(($_FILES['header']['name'] != "")) {
	    $upload_folder = '/Library/WebServer/Documents/anderswelt/img/va_header/'; //Das Upload-Verzeichnis
	    $filename = pathinfo($_FILES['header']['name'], PATHINFO_FILENAME);
	    $extension = strtolower(pathinfo($_FILES['header']['name'], PATHINFO_EXTENSION));

	    //Überprüfung der Dateigröße
	    $max_size = 5*1024*1024; //5 MB
	    if($_FILES['header']['size'] > $max_size) {
	     die("Bitte keine Dateien größer 5MB hochladen");
	    }

	    //Pfad zum Upload
	    $new_path = $upload_folder.$filename.'.'.$extension;
      $header_file = $filename.'.'.$extension;

	    //Neuer Dateiname falls die Datei bereits existiert
	    if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
	     $id = 1;
	     do {
	     $new_path = $upload_folder.$filename.'_'.$id.'.'.$extension;
       $header_file = $filename.'_'.$id.'.'.$extension;
	     $id++;
	     } while(file_exists($new_path));
	    }

	    //Alles okay, verschiebe Datei an neuen Pfad
	    move_uploaded_file($_FILES['header']['tmp_name'], $new_path);

      $va_id = addVeranstaltung($titel, $start, $ende, $header_file);
  } else {
    $va_id = addVeranstaltung($titel, $start, $ende, NULL);
  }

  if ($va_id !=0) {
    $_SESSION['success_msg'] = 'Veranstaltung "'.$titel.' "wurde erfolgreich erstellt';
  } else {
    $_SESSION['error_msg'] = 'Veranstaltung konnte nicht erstellt werden.';
  }

}
?>
