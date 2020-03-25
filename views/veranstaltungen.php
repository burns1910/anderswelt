<?php
include '../config.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/persistence/dao/VeranstaltungDAO.php';
?>    <title>Veranstaltungen</title>
<?php
include BASE_PATH.'/menu.php';

if(!isset($_SESSION['user_id'])) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {
  $connection = $database->getConnection();
  $vaDao = new VeranstaltungDAO($connection);
  $allVA = $vaDao->getAnstehendeVA();
?>
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
          <nav class="sidebar-nav">
            <ul class="nav flex-column">
              <li class="nav-item"><a class="nav-link" href="veranstaltungen.php"><i class="far fa-calendar-alt"></i> &Uuml;bersicht</a></li>
              <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#myModal"><i class="far fa-calendar-plus"></i> Veranstaltung erstellen</a></li>
            </ul>
          </nav>
        </div>
        <div class="col-sm-10">
<?php
        echo '          <h4 class="mb-4">Folgende Veranstaltungen stehen bevor:</h4>'."\n";
    if($allVA!=null) {
        foreach ($allVA as $va) {
          echo '          <div class="card bg-light mb-3" style="width:400px">'."\n";
          if($va->getHeader() != NULL) {
            echo '            <img class="card-img-top" src="/anderswelt/ressources/img/va_header/'.$va->getHeader().'" alt="'.$va->getTitel().'">'."\n";
          } else {
            echo '            <img class="card-img-top" src="/anderswelt/ressources/img/va_header/default.png" alt="'.$va->getTitel().'">'."\n";
          }
          echo '            <div class="card-title text-center">'.$va->getTitel().'</div>'."\n";
          echo '              <ul class="list-group list-group-flush">'."\n";
          echo '                <li class="list-group-item">Beginn: '.$va->getStart().'</li>'."\n";
          echo '                <li class="list-group-item">Ende: '.$va->getEnde().'</li>'."\n";
          echo '              </ul>'."\n";
          echo '              <div class="card-body">'."\n";
          echo '                <a href="gl_add_list.php?va_id='.$va->getId().'" class="btn btn-primary">Besteliste bearbeiten</a>'."\n";
          echo '                <a href="tt_edit.php?va_id='.$va->getId().'" class="btn btn-primary">Timetable bearbeiten</a>'."\n";
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
                  <input type="file" class="custom-file-input" id="customFile" name="header">
                  <label class="custom-file-label" for="customFile">Datei auswählen</label>
                </div>
                <button type="submit" class="btn btn-primary" name="create-va" value="create-va">Erstellen</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
      </script>

<?php
}
include '../footer.php';
?>
