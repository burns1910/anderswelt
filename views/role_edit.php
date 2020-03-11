<?php
include '../config.php';
include BASE_PATH.'/persistence/controller/role_form_controller.php';
include BASE_PATH.'/persistence/dao/PermissionDAO.php';
include '../header.php';
include '../menu.php';

$permissionDao = new PermissionDAO($connection);

if(!isset($_SESSION['user_id'])) {

    ?>

    <p>Willkommen beim Burns-System</p>
    <p>Bitte logge dich ein</p>


    <?php
}
else {

  if (isset($_GET['id'])) {
      $rolle = $roleDao->getRoleById($_GET['id']);
      if ((isset($rolle)) and ($rolle instanceof Role)) {

            $id = $rolle->getId();
            $name = $rolle->getName();
            $description = $rolle->getDescription();
            $allPermissions = $permissionDao->getAllPermissions();

            ?>
            <div class="container">
              <div class="row">
                <div class="col-md-4 col-md-offset-4">
                  <?php include BASE_PATH.'/utils/messages.php' ?>
                  <form method="post" action="" name="role-update-form" class="mb-4 needs-validation" novalidate>
                    <div class="form-group">
                      <label for="inputName">Name</label>
                      <input type="text" class="form-control" id="inputName" name="name" value="<?php echo $name ?>" required/>
                    </div>
                    <div class="form-group">
                      <label for="inputDescription">Beschreibung</label>
                      <textarea class="form-control" id="inputDescription" name="description" rows="5" required><?php echo $description ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="inputPermissions">Berechtigungen</label>
                      <select multiple class="form-control" id="inputPermissions">
                        <?php
                        foreach ($allPermissions as $p) {
                          $p_id = $p->getId();
                          $p_name = $p->getName();
                          //if(strcmp($r_id, $rolle_id) == 0) {
                          //  echo '<option value="'.$r_id.'" selected>'.$r_name.'</option>';
                          //} else {
                            echo '<option value="'.$p_id.'">'.$p_name.'</option>';
                          //}
                        }
                        ?>
                      </select>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary" name="edit-role" value="edit-role">&Auml;ndern</button>
                  </form>
                </div>
              </div>
            </div>
            <?php
        } else {
            $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen.';
        }
    }
}

include '../footer.php';
?>
