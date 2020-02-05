<?php
include '../config.php';
include '../controller/role_form_controller.php';
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
        $rolle = getRoleByID($_GET['id']);
        if ($rolle != 0) {

            $id = $rolle['id'];
            $name = $rolle['name'];
            $description = $rolle['description'];

            ?>
            <form method="post" action="role_add_table.php" name="role-update-form">
                <div class="form-element">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $name ?>" required/>
                </div>
                <div class="form-element">
                    <label>Beschreibung</label>
                    <textarea name="description" rows="5" cols="40"><?php echo $description ?></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" name="edit-role" value="edit-role">&Auml;ndern</button>
            </form>
            <?php
        } else {
            $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
        }
    }
}

include '../footer.php';
?>