<?php
include '../config.php';
include '../controller/user_controller.php';
include '../header.php';
include '../menu.php';

if(!$logged_in_admin) {

    ?>

    <p>Willkommen beim Burns-System</p>
    <p>Bitte logge dich ein</p>


    <?php
}
else {
    $allUsers = getAllUsers();
    if(!is_null($allUsers)) {
        echo "<div class=\"aw-tabelle\">\n";
        echo "<div class=\"aw-row aw-header aw-theme\">\n";
        echo "<div class=\"aw-cell\">\n";
        echo "Vorname";
        echo "</div>";
        echo "<div class=\"aw-cell\">\n";
        echo "Nachname";
        echo "</div>";
        echo "<div class=\"aw-cell\">\n";
        echo "Rolle";
        echo "</div>";
        echo "</div>";
        foreach ($allUsers as $user) {
            $id = $user['id'];
            echo "\t<div class=\"aw-row\">\n";
            foreach ($user as $key => $value) {
                if($key == 'id') {
                    continue;
                }
                echo "\t\t<div class=\"aw-cell\" data-title=\"".$key."\">";
                echo $value;
                echo "</div>\n";
            }
            echo '<div class="aw-cell"><a href="user_edit.php?id='.$id.'">bearbeiten</a></div>';
            echo "\t</div>\n";
        }
        echo "</div>";
    }
}
include '../footer.php';
?>