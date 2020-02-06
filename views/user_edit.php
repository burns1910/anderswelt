<?php
include '../config.php';
include '../controller/user_edit_form_controller.php';
include '../controller/role_controller.php';
include '../header.php';
include '../menu.php';

if(!$logged_in_admin) {

    ?>

    <p>Willkommen beim Burns-System</p>
    <p>Bitte logge dich ein</p>


    <?php
}
else {

    if (isset($_GET['id'])) {
        $user = getUserByID($_GET['id']);
        if ($user != 0) {
            $id = $user['id'];
            $vorname = $user['vorname'];
            $nachname = $user['nachname'];
            $rolle_id = $user['role_id'];
            $rolle_name = getRoleNameByID($rolle_id);
            $alleRollen = getAllRoles();

            ?>
            <form method="post" action="" name="role-update-form">
                <div class="form-element">
                    <label>Name</label>
                    <input type="text" name="vorname" value="<?php echo $vorname ?>" required/>
                </div>
                <div class="form-element">
                    <label>Name</label>
                    <input type="text" name="nachname" value="<?php echo $nachname ?>" required/>
                </div>
                <div class="form-element">
                    <label>Rolle</label>
                    <select name="rolle">
                        <?php
                        foreach ($alleRollen as $r) {
                            $r_id = $r['id'];
                            $r_name = $r['name'];
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
                <button type="submit" name="edit-user" value="edit-user">&Auml;ndern</button>
            </form>
            <?php
        } else {
            $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
        }
    }
}

include '../footer.php';
?>