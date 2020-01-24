<?php
include '../config.php';
include '../controller/list_controller.php';
include '../controller/crew_controller.php';
include '../header.php';
include '../menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$crewmember = getDataFromCrewMemberByID($id);
		$AlleListen = listeAllerCrewListen();
		$IDsSelektierterListen = getAllListIDsFromCrewMember($crewmember['id']); // original List
		$selected = false;
?>
		<form method="post" action="crew_add_table.php" name="crew-update-form">
		    <div class="form-element">
		        <label>Name</label>
		        <input type="text" name="name" value="<?php echo $crewmember['name']?>" required />
		    </div>
		    <div class="form-element">
		        <label>E-Mail</label>
		        <input type="email" name="email" value="<?php echo $crewmember['email']?>" />
		    </div>
		    <div class="form-element">
		        <label>Telefon</label>
		        <input type="text" name="telefon" value="<?php echo $crewmember['telefon']?>" />
		    </div>
		    <div class="form-element">
		        <label>Kommentar</label>
		        <textarea name="kommentar" rows="10" cols="30"><?php echo $crewmember['kommentar']?></textarea>
		    </div>

		    <div class="form-element">
		        <label>Verteilerlisten</label>
		            <select name="listen[]" size="10" multiple="true">
		<?php
		    foreach ($AlleListen as $liste) {
		    	if(in_array($liste['id'], $IDsSelektierterListen)) {
					echo '<option value="'.$liste['id'].'" title="'.$liste['beschreibung'].'" selected>'.$liste['name'].'</option>';
				} else {
					echo '<option value="'.$liste['id'].'" title="'.$liste['beschreibung'].'">'.$liste['name'].'</option>';
				}
		    }
		?>
		            </select>
		    </div>

		    <input type="hidden" name="crew-member-id" value="<?php echo $id; ?>">
		    <button type="submit" name="update-crew-member" value="update-crew-member">Speichern</button>
		    <button type="reset" name="reset-form">Reset</button>
		</form>

<?php
	}

}
include '../footer.php';
?>