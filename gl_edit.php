<?php
include 'config.php';
include './controller/gl_controller.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {

	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$gl_edit = getGLPlatzByID($id);
		$gl_plus = $gl_edit['plus'];
		$gl_typ = $gl_edit['type'];
		$va_id = $gl_edit['va_id'];
?>
		<form method="post" action="gl_add_list.php?va_id=<?php echo $va_id?>" name="gl-update-form">
		    <div class="form-element">
		        <label>Name</label>
		        <input type="text" name="name" value="<?php echo $gl_edit['name']?>" required />
		    </div>
		    <div class="form-element">
		        <label>Typ</label>
		        <select name="type">
		        	<option value="0" <?php if($gl_typ == "0") echo "selected"?> >Besteliste</option>
		        	<option value="1" <?php if($gl_typ == "1") echo "selected"?> >Halfprice</option>
		        	<option value="2" <?php if($gl_typ == "2") echo "selected"?> >Schneggoliste</option>
		        </select>
		    </div>
		    <div class="form-element">
		        <label>Plus</label>
		        <select name="plus">
		        	<option value="0" <?php if($gl_plus == "0") echo "selected"?> >0</option>
		        	<option value="1" <?php if($gl_plus == "1") echo "selected"?> >1</option>
		        	<option value="2" <?php if($gl_plus == "2") echo "selected"?> >2</option>
		        	<option value="3" <?php if($gl_plus == "3") echo "selected"?> >3</option>
		        	<option value="4" <?php if($gl_plus == "4") echo "selected"?> >4</option>
		        	<option value="5" <?php if($gl_plus == "5") echo "selected"?> >5</option>
		        </select>
		    </div>
		    <input type="hidden" name="id" value="<?php echo $id; ?>">
		    <button type="submit" name="edit-gl" value="edit-gl">&Auml;ndern</button>
		</form>

<?php
	}

}
include 'footer.php';
?>