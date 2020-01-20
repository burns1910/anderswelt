<?php
include 'config.php';
include './controller/list_controller.php';
include './controller/crew_form_controller.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {
    $listen = listeAllerCrewListen();
    $hashtags = listeAllerHashTags();
?>
    <form method="get" action="" name="filter-crew-list">
        <div class="form-element">
            <label>Filter-Liste:</label>
                <select name="filter-liste">
                    <option value="all">Alle</option>
        <?php
                    foreach ($listen as $liste) {
                    echo '<option value="'.$liste['id'].'" title="'.$liste['beschreibung'].'">'.$liste['name'].'</option>';
        }
        ?>
                </select>
        </div>

        <div class="form-element">
            <label>Filter-#:</label>
                <select name="filter-tag">
                    <option value="no-tag">No-Filter</option>
        <?php
            foreach ($hashtags as $hashtag) {
                echo '<option value="'.$hashtag['tag'].'">'.$hashtag['tag'].'</option>';
            }
        ?>
                </select>
        </div>
        <button type="submit" name="" value="">Filtern</button>
    </form>

<?php

    if(!is_null($crewList)) {
        echo "<div class=\"aw-tabelle\">\n";
            echo "<div class=\"aw-row aw-header aw-theme\">\n";
                echo "<div class=\"aw-cell\">\n";
                echo "Name";
                echo "</div>";

                echo "<div class=\"aw-cell\">\n";
                echo "E-Mail";
                echo "</div>";

                echo "<div class=\"aw-cell\">\n";
                echo "Telefon";
                echo "</div>";
            echo "</div>";
        foreach ($crewList as $crewmember) {
            $id = $crewmember['id'];
            echo "\t<div class=\"aw-row\">\n";
            foreach ($crewmember as $key => $value) {
                if($key == 'id' || $key == 'kommentar' ) {
                    continue;
                }
                echo "\t\t<div class=\"aw-cell\" data-title=\"".$key."\" title=\"".$crewmember['kommentar']."\">";
                echo $value;
                echo "</div>\n";
            }
            echo '<div class="aw-cell"><a href="crew_edit.php?id='.$id.'">bearbeiten</a></div>';
            echo "\t</div>\n";
        }
        echo "</div>";
    }
?>

    <form method="post" action="" name="signup-crew-form">
        <div class="form-element">
            <label>Name</label>
            <input type="text" name="name" required />
        </div>
        <div class="form-element">
            <label>E-Mail</label>
            <input type="email" name="email"/>
        </div>
        <div class="form-element">
            <label>Telefon</label>
            <input type="text" name="telefon"/>
        </div>
        <div class="form-element">
            <label>Kommentar</label>
            <textarea name="kommentar" rows="20" cols="50"></textarea>
        </div>
        <div class="form-element">
            <label>Verteilerlisten</label>
                <select name="listen[]" size="10" multiple="true">
    <?php
        foreach ($listen as $liste) {
            echo '<option value="'.$liste['id'].'" title="'.$liste['beschreibung'].'">'.$liste['name'].'</option>';
        }
    ?>
                </select>
        </div>


        <button type="submit" name="register-crew-member" value="register">Hinzuf&uuml;gen</button>
    </form>

<?php
}
include 'footer.php';
?>