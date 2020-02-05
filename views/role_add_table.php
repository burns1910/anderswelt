<?php
include '../config.php';
include '../controller/role_form_controller.php';
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
    <form method="post" action="" name="role-add-form">
        <div class="form-element">
            <label>Name</label>
            <input type="text" name="name" required />
        </div>
        <div class="form-element">
            <label>Beschreibung</label>
            <textarea name="description" rows="5" cols="40"></textarea>
        </div>
        <button type="submit" name="add-role" value="add-role">Hinzuf&uuml;gen</button>
    </form>

<?php
    $alleRollen = getAllRoles();
    if(!is_null($alleRollen)) {
        echo "<div class=\"aw-tabelle\">\n";
        echo "<div class=\"aw-row aw-header aw-theme\">\n";
        echo "<div class=\"aw-cell\">\n";
        echo "Name";
        echo "</div>";
        echo "</div>";
        foreach ($alleRollen as $rolle) {
            $id = $rolle['id'];
            echo "\t<div class=\"aw-row\">\n";
            foreach ($rolle as $key => $value) {
                if($key == 'id' || $key == 'description' ) {
                    continue;
                }
                echo "\t\t<div class=\"aw-cell\" data-title=\"".$key."\" title=\"".$rolle['description']."\">";
                echo $value;
                echo "</div>\n";
            }
            echo '<div class="aw-cell"><a href="role_edit.php?id='.$id.'">bearbeiten</a></div>';
            echo '<div class="aw-cell"><a href="role_add_table.php?action=delete&id='.$id.'">l&ouml;schen</a></div>';
            echo "\t</div>\n";
        }
        echo "</div>";
    }
}
include '../footer.php';
?>