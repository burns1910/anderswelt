<?php
include 'config.php';
include './controller/list_controller.php';
include './controller/crew_controller.php';
include './controller/mail_form_controller.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {
	$alleListen = listeAllerCrewListen();
	$alleAbsender = listeAllerAbsender();
	$crew_member_list = listeAllerCrewMember();

?>
		<form method="post" enctype="multipart/form-data" action="" name="mail-an-liste">
			<div class="form-element">
		        <label>Absender-Name</label>
		        <input type="text" name="absender-name" required />
		    </div>

		    <div class="form-element">
		        <label>Absender-Adresse:</label>
		        	<select name="absender-adresse">
		<?php
		    foreach ($alleAbsender as $absender) {
				echo '<option value="'.$absender.'">'.$absender.'</option>';
		    }
		?>
					</select>
		    </div>

		    <div class="form-element">
		        <label>Empf&auml;nger-Listen</label>
		            <select name="listen[]" size="10" multiple="true">
		<?php
		    foreach ($alleListen as $liste) {
				echo '<option value="'.$liste['id'].'" title="'.$liste['beschreibung'].'">'.$liste['name'].'</option>';
		    }
		?>
		            </select>
		    </div>

		<div class="form-element">
		        <label>Empf&auml;nger-Personen</label>
		            <select name="crew_member[]" size="10" multiple="true">
		<?php
		    foreach ($crew_member_list as $crew_member) {
		        echo '<option value="'.$crew_member['id'].'" title="'.$crew_member['kommentar'].'">'.$crew_member['name'].'</option>';
		    }
		?>
		            </select>
		    </div>


		    <div class="form-element">
		        <label>Betreff</label>
		        <input type="text" name="betreff" required />
		    </div>
		    <div class="form-element">
		        <label>Text</label>
		        <textarea name="text" rows="10" cols="30"></textarea>
		    </div>

			<div class="form-element">
		        <label>Anhang</label>
		        <input type="file" name="datei">
		    </div>


		    <button type="submit" name="send-mail-to-lists" value="send-mail-to-lists">Senden</button>
		</form>

<?php
}
include 'footer.php';
?>