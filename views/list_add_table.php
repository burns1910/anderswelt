<?php
include '../config.php';
include '../controller/crew_controller.php';
include '../controller/list_form_controller.php';
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

<form method="post" action="" name="create-crew-list-form">
    <div class="form-element">
        <label>Name der Liste</label>
        <input type="text" name="name" required />
    </div>
    <div class="form-element">
        <label>Beschreibung</label>
        <textarea name="beschreibung" rows="20" cols="50"></textarea>
    </div>
        
    <div class="form-element">
        <label>Mitglieder</label>
            <select name="crew_member[]" size="10" multiple="true">
<?php
    $crew_member_list = listeAllerCrewMember();
    foreach ($crew_member_list as $crew_member) {
        echo '<option value="'.$crew_member['id'].'" title="'.$crew_member['kommentar'].'">'.$crew_member['name'].'</option>';
    }
?>
            </select>
    </div>
    <button type="submit" name="add-crew-liste" value="register">Hinzuf&uuml;gen</button>
</form>

<?php
    $alleListen = listeAllerCrewListen();
    if(!is_null($alleListen)) {
        echo "<div class=\"aw-tabelle\">\n";
            echo "<div class=\"aw-row aw-header aw-theme\">\n";
                echo "<div class=\"aw-cell\">\n";
                echo "Name";
                echo "</div>";
            echo "</div>";
        foreach ($alleListen as $liste) {
            $id = $liste['id'];
            echo "\t<div class=\"aw-row\">\n";
            foreach ($liste as $key => $value) {
                if($key == 'id' || $key == 'beschreibung' ) {
                    continue;
                }
                echo "\t\t<div class=\"aw-cell\" data-title=\"".$key."\" title=\"".$liste['beschreibung']."\">";
                echo $value;
                echo "</div>\n";
            }
            echo '<div class="aw-cell"><a href="list_edit.php?id='.$id.'">bearbeiten</a></div>';
            echo "\t</div>\n";
        }
        echo "</div>";
    }
}
include '../footer.php';
?>