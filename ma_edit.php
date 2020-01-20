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

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$mitarbeiter = getDataFromMitarbeiterByID($id);
?>
		<form method="post" action="" name="ma-update-form">
	    <div class="form-element">
<?php
			echo $mitarbeiter['vorname']. ' '.$mitarbeiter['nachname']. ' sind folgende Bereiche zugewiesen:<br /><br />'; //Schöner machen mit Nick usw.
?>
	        <input type="checkbox" name="cvd" value="1" <?php if($mitarbeiter['cvd']==1) echo 'checked'?>>Chef vom Dienst<br />
	        <input type="checkbox" name="cvt" value="1" <?php if($mitarbeiter['cvt']==1) echo 'checked'?>>Chef von Technik<br />
	        <input type="checkbox" name="selector" value="1"<?php if($mitarbeiter['selector']==1) echo 'checked'?>>Selector<br />
	        <input type="checkbox" name="kasse" value="1"<?php if($mitarbeiter['kasse']==1) echo 'checked'?>>Kasse<br />
	        <input type="checkbox" name="tresenmuetze" value="1"<?php if($mitarbeiter['tresenmuetze']==1) echo 'checked'?>>Tresenm&uuml;tze<br />
	        <input type="checkbox" name="tresen" value="1"<?php if($mitarbeiter['tresen']==1) echo 'checked'?>>Tresen<br />
	        <input type="checkbox" name="runner" value="1"<?php if($mitarbeiter['runner']==1) echo 'checked'?>>Runner<br />
	        <input type="checkbox" name="garderobe" value="1"<?php if($mitarbeiter['garderobe']==1) echo 'checked'?>>Garderobe<br />
	        <input type="checkbox" name="hofmuetze" value="1"<?php if($mitarbeiter['hofmuetze']==1) echo 'checked'?>>Hofm&uuml;tze<br />
	        <input type="checkbox" name="hofwache" value="1"<?php if($mitarbeiter['hofwache']==1) echo 'checked'?>>Hofwache<br />
	        <input type="checkbox" name="awareness" value="1"<?php if($mitarbeiter['awareness']==1) echo 'checked'?>>Awareness<br />
	        <input type="checkbox" name="hygiene" value="1"<?php if($mitarbeiter['hygiene']==1) echo 'checked'?>>Hygiene Hero<br />
	        <input type="hidden" name="ma-id" value="<?php echo $id; ?>">
	    </div>
	    <button type="submit" name="update-ma" value="update-ma">Speichern</button>
	</form>

<?php
	}

}
include 'footer.php';
?>