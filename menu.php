<?php
$home_url = BASE_URL."index.php";
$logout_url = BASE_URL."logout.php";
if(!$logged_in_admin) {
?>

    <div class="topnav">
      <a class="active" href="<?php echo $home_url?>"><i class="fa fa-fw fa-home"></i> Home</a>
    </div>
    <div class="aw-content">

<?php
} else {

  $home = array(
    "/anderswelt/index.php");
  $veranstaltungen = array(
    "/anderswelt/views/va_add_list.php",
    "/anderswelt/views/gl_add_list.php",
    "/anderswelt/views/gl_edit.php");
  $kommunikation = array(
    "/anderswelt/menu_komm.php",
    "/anderswelt/views/crew_add_table.php",
    "/anderswelt/views/crew_edit.php",
    "/anderswelt/views/mail.php",
    "/anderswelt/views/list_add_table.php");
  $bauprojekte = array(
    "/anderswelt/menu_bau.php");

  $aktuelle_seite = $_SERVER['PHP_SELF'];

  $menu_html = '<div class="topnav">';
  if(in_array($aktuelle_seite, $home)) {
      $menu_html .='<a class="active" href="'.$home_url.'"><i class="fas fa-home"></i> Home</a>';
  } else {
      $menu_html .='<a href="'.$home_url.'"><i class="fas fa-home"></i> Home</a>';
  }
  $va_url = BASE_URL."/views/va_add_list.php";
  if(in_array($aktuelle_seite, $veranstaltungen)) {
      $menu_html .='<a class="active" href="'.$va_url.'"><i class="far fa-calendar-alt"></i> Veranstaltungen</a>';
  } else {
    $menu_html .='<a href="'.$va_url.'"><i class="far fa-calendar-alt"></i> Veranstaltungen</a>';
  }
  $komm_url = BASE_URL."menu_komm.php";
  if(in_array($aktuelle_seite, $kommunikation)) {
      $menu_html .='<a class="active" href="'.$komm_url.'"><i class="fas fa-comments"></i> Kommunikation</a>';
  } else {
    $menu_html .='<a href="'.$komm_url.'"><i class="fas fa-comments"></i> Kommunikation</a>';
  }
  $bau_url = BASE_URL."menu_bau.php";
  if(in_array($aktuelle_seite, $bauprojekte)) {
      $menu_html .='<a class="active" href="'.$bau_url.'"><i class="fas fa-hard-hat"></i> Bauprojekte</a>';
  } else {
      $menu_html .='<a href="'.$bau_url.'"><i class="fas fa-hard-hat"></i> Bauprojekte</a>';
  }
  echo $menu_html;
?>

      <div class="topnav-right">
      	<a href="<?php echo $logout_url?>"><i class="fas fa-user-times"></i> Logout</a>
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