<?php

if(!$logged_in_admin) {
?>

    <div class="topnav">
      <a class="active" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
    </div>
    <div class="aw-content">

<?php
} else {

  $home = array(
    "/index.php");
  $mitarbeiter = array(
    "/menu_ma.php", 
    "/ma_tabelle.php", 
    "/ma_edit.php");
  $veranstaltungen = array(
    "/va_add_list.php",
    "/gl_add_list.php",
    "/gl_edit.php");
  $kommunikation = array(
    "/menu_komm.php", 
    "/crew_add_table.php",  
    "/crew_edit.php", 
    "/mail.php",
    "/list_add_table.php");
  $bauprojekte = array(
    "/menu_bau.php");

  $aktuelle_seite = $_SERVER['PHP_SELF'];

  $menu_html = '<div class="topnav">';
  if(in_array($aktuelle_seite, $home)) {
    $menu_html .='<a class="active" href="index.php"><i class="fas fa-home"></i> Home</a>';
  } else {
    $menu_html .='<a href="index.php"><i class="fas fa-home"></i> Home</a>';
  }
  if(in_array($aktuelle_seite, $mitarbeiter)) {
    $menu_html .='<a class="active" href="menu_ma.php"><i class="far fa-heart"></i> Mitarbeiter</a>';
  } else {
    $menu_html .='<a href="menu_ma.php"><i class="far fa-heart"></i> Mitarbeiter</a>';
  }
  if(in_array($aktuelle_seite, $veranstaltungen)) {
    $menu_html .='<a class="active" href="va_add_list.php"><i class="far fa-calendar-alt"></i> Veranstaltungen</a>';
  } else {
    $menu_html .='<a href="va_add_list.php"><i class="far fa-calendar-alt"></i> Veranstaltungen</a>';
  }
  if(in_array($aktuelle_seite, $kommunikation)) {
    $menu_html .='<a class="active" href="menu_komm.php"><i class="fas fa-comments"></i> Kommunikation</a>';
  } else {
    $menu_html .='<a href="menu_komm.php"><i class="fas fa-comments"></i> Kommunikation</a>';
  }
  if(in_array($aktuelle_seite, $bauprojekte)) {
    $menu_html .='<a class="active" href="menu_bau.php"><i class="fas fa-hard-hat"></i> Bauprojekte</a>';
  } else {
    $menu_html .='<a href="menu_bau.php"><i class="fas fa-hard-hat"></i> Bauprojekte</a>';
  }
  echo $menu_html;
?>

      <div class="topnav-right">
      	<a href="logout.php"><i class="fas fa-user-times"></i> Logout</a> 
      </div>
    </div>
    <div class="aw-content">
<?php
}
if (isset($message)) {
	echo $message;
  unset($message);
}
?>