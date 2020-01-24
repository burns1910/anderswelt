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
    $veranstaltungen = getAnstehendeVA();
    if($veranstaltungen!=null) {
        echo '<p>Folgende Veranstaltungen stehen bevor:</p><br />';
        foreach ($veranstaltungen as $va) {
            echo $va['titel'].'<br />';
            echo ' Beginn: '.$va['start'].'<br />';
            echo ' Ende: '.$va['ende'].'<br />';
            echo '<p><a href="gl_add_list.php?va_id='.$va['id'].'">Besteliste bearbeiten</a></p><br />';
        }
    }
?>

<form method="post" action="" name="va-create-form">
    <div class="form-element">
        <label>Titel</label>
        <input type="text" name="titel" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Start-Datum <br />(YYYY-MM-DD)</label>
        <input type="date" name="start_tag" required />
    </div>
    <div class="form-element">
        <label>Start-Uhrzeit <br />(HH:MM)</label>
        <input type="time" name="start_zeit" required />
    </div>    
    <div class="form-element">
        <label>Ende-Datum <br />(YYYY-MM-DD)</label>
        <input type="date" name="ende_tag" required />
    </div>
    <div class="form-element">
        <label>Ende-Uhrzeit <br />(HH:MM)</label>
        <input type="time" name="ende_zeit" required />
    </div>    

    <button type="submit" name="create-va" value="register">Erstellen</button>
</form>
<?php 
}
include '../footer.php';
?>