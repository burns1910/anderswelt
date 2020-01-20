<?php
include 'config.php';
include './controller/va_controller.php';
include './controller/gl_form_controller.php';
include 'header.php';
include 'menu.php';

if(!$logged_in_admin) {

?>

<p>Willkommen beim Burns-System</p>
<p>Bitte logge dich ein</p>


<?php
}
else {

	if(isset($_GET['va_id'])) {
		$va_id = $_GET['va_id'];
		$va = getVAByID($va_id);
		$va_name = $va['titel'];

		$gl_plaetze = getAllListGLPlaetzeByVAID($va_id);

		echo "<p>Besteliste für Veranstaltung: $va_name</p>";

	    if(!is_null($gl_plaetze)) {
	        echo "<div class=\"aw-tabelle\">\n";
	            echo "<div class=\"aw-row aw-header aw-theme\">\n";
	                echo "<div class=\"aw-cell\">\n";
	                echo "Name";
	                echo "</div>";

	                echo "<div class=\"aw-cell\">\n";
	                echo "Plus";
	                echo "</div>";

	                echo "<div class=\"aw-cell\">\n";
	                echo "Listen-Typ";
	                echo "</div>";
	            echo "</div>";
	        foreach ($gl_plaetze as $gl_platz) {
	            $id = $gl_platz['id'];
	            echo "\t<div class=\"aw-row\">\n";
	            foreach ($gl_platz as $key => $value) {
	                if($key == 'id' || $key == 'va_id' || $key == 'erschienen') {
	                    continue;
	                }
	                $type_string = "";
	                if($key == 'type') {
	                    $type_string = glTypString($value);
	                    echo "\t\t<div class=\"aw-cell\" data-title=\"".$type_string."\">";
	                    echo $type_string;
	                } else {
	                	echo "\t\t<div class=\"aw-cell\" data-title=\"".$value."\">";
	                	echo $value;
	                }
	                echo "</div>\n";
	            }
	            echo '<div class="aw-cell"><a href="gl_edit.php?id='.$id.'">bearbeiten</a></div>';
	            echo "\t</div>\n";
	        }
	        echo "</div>";
	    }
?>





		<form method="post" action="" name="gl-add-form">
		    <div class="form-element">
		        <label>Name</label>
		        <input type="text" name="name" required />
		    </div>
		    <div class="form-element">
		        <label>Typ</label>
		        <select name="type">
		        	<option value="0">Besteliste</option>
		        	<option value="1">Halfprice</option>
		        	<option value="2">Schneggoliste</option>
		        </select>
		    </div>
		    <div class="form-element">
		        <label>Plus</label>
		        <select name="plus">
		        	<option value="0">0</option>
		        	<option value="1">1</option>
		        	<option value="2">2</option>
		        	<option value="3">3</option>
		        	<option value="4">4</option>
		        	<option value="5">5</option>
		        </select>
		    </div>
		    <input type="hidden" name="va_id" value="<?php echo $va_id; ?>">
		    <button type="submit" name="add-gl" value="add-gl">Hinzuf&uuml;gen</button>
		</form>

<?php
	}
}
include 'footer.php';
?>