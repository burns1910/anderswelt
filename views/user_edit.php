<?php
include '../config.php';
include BASE_PATH.'/persistence/controller/user_edit_form_controller.php';
include BASE_PATH.'/persistence/dao/RoleDAO.php';
include '../header.php';
include '../menu.php';

$roleDao = new RoleDAO($connection);

if(!isset($_SESSION['user_id'])) {

    ?>

    <p>Willkommen beim Burns-System</p>
    <p>Bitte logge dich ein</p>


    <?php
}
else {

    if (isset($_GET['id'])) {
        $user = $userDao->getUserById($_GET['id']);
        if ((isset($user)) and ($user instanceof User)) {
            $id = $user->getId();
            $vorname = $user->getVorname();
            $nachname = $user->getNachname();
            $rolle_id = $user->getRoleId();
            $rolle = $roleDao->getRoleById($rolle_id);
            if ((isset($rolle)) and ($rolle instanceof Rolle)) {
              $rolle_name = $rolle->getName();
            }
            $alleRollen = $roleDao->getAllRoles();

            ?>
            <div class="container">
              <div class="row">
                <div class="col-md-4 col-md-offset-4">
                  <?php include BASE_PATH.'/utils/messages.php' ?>
                  <form method="post" action="" name="user-update-form" class="mb-4 needs-validation" novalidate>
                    <div class="form-group">
                      <label for="inputVorname">Vorname</label>
                      <input type="text" class="form-control" id="inputVorname" name="vorname" value="<?php echo $vorname ?>" required/>
                    </div>
                    <div class="form-group">
                      <label for="inputName">Name</label>
                      <input type="text" class="form-control" id="inputName" name="nachname" value="<?php echo $nachname ?>" required/>
                    </div>
                    <div class="form-group">
                      <label for="inputRolle">Rolle</label>
                      <select class="form-control" id="inputRolle" name="rolle">
                        <?php
                        foreach ($alleRollen as $r) {
                          $r_id = $r->getId();
                          $r_name = $r->getName();
                          if(strcmp($r_id, $rolle_id) == 0) {
                            echo '<option value="'.$r_id.'" selected>'.$r_name.'</option>';
                          } else {
                            echo '<option value="'.$r_id.'">'.$r_name.'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary" name="edit-user" value="edit-user">&Auml;ndern</button>
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
