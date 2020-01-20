<?php
include 'config.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {

	echo '<a class="aw-center-text" href="ma_tabelle.php">Zeige alle Mitarbeiter</a><br />';

}
include 'footer.php';
?>