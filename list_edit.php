<?php
include 'config.php';
include './controller/crew_controller.php';
include './controller/list_controller.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$liste = getDataFromCrewListeByID($id);
		$crew_member_list = listeAllerCrewMember();
		$IDsSelektierterCrewMember = getAllMemberIDsFromList($liste['id']); // original MemberList
		$selected = false;
?>
		<form method="post" action="list_add_table.php" name="list-update-form">
		    <div class="form-element">
		        <label>Name der Liste</label>
		        <input type="text" name="name" value="<?php echo $liste['name']?>" required />
		    </div>
		    <div class="form-element">
		        <label>Beschreibung</label>
		        <textarea name="beschreibung" rows="20" cols="50"><?php echo $liste['beschreibung']?></textarea>
		    </div>

		    <div class="form-element">
		        <label>Mitglieder</label>
		            <select name="crew_member[]" size="10" multiple="true">

		<?php
		    foreach ($crew_member_list as $crew_member) {
		    	if(in_array($crew_member['id'], $IDsSelektierterCrewMember)) {
					echo '<option value="'.$crew_member['id'].'" title="'.$crew_member['beschreibung'].'" selected>'.$crew_member['name'].'</option>';
				} else {
					echo '<option value="'.$crew_member['id'].'" title="'.$crew_member['beschreibung'].'">'.$crew_member['name'].'</option>';
				}
		    }
		?>
		            </select>
		    </div>

		    <input type="hidden" name="list-id" value="<?php echo $id; ?>">
		    <button type="submit" name="edit-crew-liste" value="edit-crew-liste">Speichern</button>
		    <button type="submit" name="reset-form">Reset</button>
		</form>

<?php
	}

}
include 'footer.php';
?>