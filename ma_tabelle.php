<?php
include 'config.php';
include './controller/ma_form_controller.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {
	$alleMitarbeiter = listeAllerMitarbeiterShort();
?>
	<div class="aw-table">
		<div class="aw-row aw-header aw-theme">
			<div class="aw-cell">Vorname</div>
			<div class="aw-cell">Nachname</div>
			<div class="aw-cell">Nick</div>
			<div class="aw-cell">E-Mail</div>
			<div class="aw-cell">Verified</div>
			<div class="aw-cell">Aktiv</div>
			<div class="aw-cell">CvD</div>
			<div class="aw-cell">CvT</div>
			<div class="aw-cell">Selector</div>
			<div class="aw-cell">Kasse</div>
			<div class="aw-cell">Tresenm&uuml;tze</div>
			<div class="aw-cell">Tresen</div>
			<div class="aw-cell">Runner</div>
			<div class="aw-cell">Garderobe</div>
			<div class="aw-cell">Hofm&uuml;</div>
			<div class="aw-cell">Hofwache</div>
			<div class="aw-cell">Awareness</div>
			<div class="aw-cell">Hygiene</div>
		</div>
<?php
	foreach ($alleMitarbeiter as $mitarbeiter) {
		$id = $mitarbeiter['id'];
		$active = $mitarbeiter['aktiv'];
		$active_text = ($active==0) ? "aktivieren" : "deaktivieren" ;
		echo "\t<div class=\"aw-row\">\n";
		foreach ($mitarbeiter as $key => $value) {
			if($key == 'id') {
				continue;
			}
			echo "\t\t<div class=\"aw-cell\" data-title=\"".$key."\">";
			echo $value;
			echo "</div>\n";
		}
		echo '<div class="aw-cell"><a href="ma_edit.php?id='.$id.'">bearbeiten</a></div>';
		// aktivieren oder deaktivieren
		echo '<div class="aw-cell"><a href="ma_tabelle.php?edit='.$active_text.'&id='.$id.'">'.$active_text.'</a></div>';
		echo "\t</div>\n";
	}
	echo "</div>";

}
include 'footer.php';
?>