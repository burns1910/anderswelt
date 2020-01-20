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
	echo '<img src="./img/snail.png"><br /> Bitte nicht so snail!';

}
include 'footer.php';
?>