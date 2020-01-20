<?php

if (isset($_POST['login'])) {
 
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    $query = $connection->prepare("SELECT * FROM user WHERE EMAIL=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
 
    $result = $query->fetch(PDO::FETCH_ASSOC);
 
    if (!$result) {
        $message = '<p class="aw-error-message">E-Mail Password Kombination konnte nicht verifiziert werden!</p><br />';
    } else {
        if ((password_verify($password, $result['pw_hash'])) && ($result['aktiv'] == 1)) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['user_vorname'] = $result['vorname'];
            $_SESSION['user_nachname'] = $result['nachname'];
            $_SESSION['user_email'] = $result['email'];
            header("Location: index.php");
        } else {
            $message = '<p class="aw-error-message">E-Mail Password Kombination konnte nicht verifiziert werden!</p><br />';
        }
    }
}
?>