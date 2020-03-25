<?php
include '../config.php';
include BASE_PATH.'/header.php';
?>
    <title>Admin</title>
<?php
include BASE_PATH.'/menu.php';

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {
?>
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
          <nav class="sidebar-nav">
            <ul class="nav flex-column">
              <li class="nav-item"><a class="nav-link" href="users.php"><i class="far fa-user"></i> User</a></li>
              <li class="nav-item"><a class="nav-link" href="roles.php"><i class="fas fa-users"></i> Rollen</a></li>
              <li class="nav-item"><a class="nav-link" href="permissions.php"><i class="far fa-id-card"></i> Berechtigungen</a></li>
            </ul>
          </nav>
        </div>
        <div class="col-sm-10">
          <h2>Administration</h2>
        </div>
      </div>
    </div>

<?php
}
include BASE_PATH.'/footer.php';
?>
