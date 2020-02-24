<?php
include '../config.php';
include '../controller/va_form_controller.php';
include '../header.php';
include '../menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {
?>
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="row col-xl-2">
          <ul>
            <li>
              <a href="va_add_list.php"><i class="far fa-calendar-alt"></i> &Uuml;bersicht</a>
            </li>
            <li>
              <a href="#" data-toggle="modal" data-target="#myModal"><i class="far fa-calendar-plus"></i> Veranstaltung erstellen</a>
            </li>
          </ul>
        </div>
        <div class="col-xl-10">
<?php

    $veranstaltungen = getAnstehendeVA();
    if($veranstaltungen!=null) {
        echo '          <h4 class="mb-4">Folgende Veranstaltungen stehen bevor:</h4>'."\n";
        foreach ($veranstaltungen as $va) {
          echo '          <div class="card bg-light mb-3" style="width:400px">'."\n";
          echo '            <img class="card-img-top" src="/anderswelt/img/header/'.$va['header'].'.png" alt="'.$va['titel'].'">'."\n";
          echo '            <div class="card-title text-center">'.$va['titel'].'</div>'."\n";
          echo '              <ul class="list-group list-group-flush">'."\n";
          echo '                <li class="list-group-item">Beginn: '.$va['start'].'</li>'."\n";
          echo '                <li class="list-group-item">Ende: '.$va['ende'].'</li>'."\n";
          echo '              </ul>'."\n";
          echo '              <div class="card-body">'."\n";
          echo '                <a href="gl_add_list.php?va_id='.$va['id'].'" class="btn btn-primary">Besteliste bearbeiten</a>'."\n";
          echo '                <a href="tt_edit.php?va_id='.$va['id'].'" class="btn btn-primary">Timetable bearbeiten</a>'."\n";
          echo '              </div>'."\n";
          echo '            </div>'."\n";
        }
    }
?>
          </div>
        </div>
      </div>
      <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Neue Veranstaltung</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="post" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                  <div class="form-group">
                      <label for="inputTitel">Titel</label>
                      <input type="text" class="form-control" id="inputTitel" name="titel" pattern="[a-zA-Z0-9]+" required />
                  </div>
                  <div class="form-group">
                      <label for="inputStartDatum">Start-Datum:</label>
                      <input type="date" class="form-control" id="inputStartDatum" name="start_tag" required />
                  </div>
                  <div class="form-group">
                      <label for="inputStartZeit">Start-Uhrzeit:</label>
                      <input type="time" class="form-control" id="inputStartZeit" name="start_zeit" required />
                  </div>
                  <div class="form-group">
                      <label for="inputEndeDatum">Ende-Datum:</label>
                      <input type="date" class="form-control" id="inputEndeDatum" name="ende_tag" required />
                  </div>
                  <div class="form-group">
                      <label for="inputEndeZeit">Ende-Uhrzeit:</label>
                      <input type="time" class="form-control" id="inputEndeZeit" name="ende_zeit" required />
                  </div>
                  <p>Header:</p>
                  <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" id="headerFile" name="header">
                    <label class="custom-file-label" for="headerFile">Datei auswählen</label>
                  </div>
                  <button type="submit" class="btn btn-primary" name="create-va" value="create-va">Erstellen</button>
              </form>
            </div>
          </div>
        </div>
      </div>

<?php
}
include '../footer.php';
?>
