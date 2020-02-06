<?php

    function addUser($role_id, $vorname, $nachname, $email, $token, $pw_hash, $token_expire_date) {
        global $connection;

        $query = $connection->prepare("INSERT INTO user(ROLE_ID,VORNAME,NACHNAME,EMAIL,TOKEN,PW_HASH,TOKEN_EXPIRE_DATE) VALUES (:role_id,:vorname,:nachname,:email,:token,:pw_hash,:token_expire_date)");
        $query->bindParam("role_id", $role_id, PDO::PARAM_STR);
        $query->bindParam("vorname", $vorname, PDO::PARAM_STR);
        $query->bindParam("nachname", $nachname, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("token", $token, PDO::PARAM_STR);
        $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
        $query->bindParam("token_expire_date", $token_expire_date, PDO::PARAM_STR);

        try {
            $connection->beginTransaction();
            $query->execute();
            $retval = $connection->lastInsertId();
            $connection->commit();
        } catch(PDOExecption $e) {
            $connection->rollback();
            print($e->getMessage());
            $retval = 0;
        }

        return $retval;
    }

    function doesUserExist($email) {
        global $connection;
        $retval = false;

        $query = $connection->prepare("SELECT * FROM user WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount() > 0) {
            $retval = true;
        }
    return $retval;
    }

    function isEmailVerified($email) {
        global $connection;

        $query = $connection->prepare("SELECT mail_verified FROM user WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $retval = $result['mail_verified'];
    return $retval;
    }

    function verifyEmail($email) {
        global $connection;

        $query = $connection->prepare("UPDATE user SET mail_verified='1' WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    }

    function getMailFromUserByID($user_id) {
        global $connection;
        $query = $connection->prepare("SELECT email FROM user WHERE ID=:id");
        $query->bindParam("id", $user_id, PDO::PARAM_STR);
        $query->execute();
 
        $mail = $query->fetch(PDO::FETCH_ASSOC);
        $retval = $mail['email'];
    return $retval;
    }

    function getTokenExpireDateByUserID($user_id) {
        global $connection;
        $retval = 0;

        $query = $connection->prepare("SELECT token_expire_date FROM user WHERE ID=:user_id");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $date = $result['token_expire_date'];
        $retval = strtotime($date);
    return $retval;
    }

    function getUserByMail($email) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM user WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

    function updatePWByMail($email, $pw_hash) {
        global $connection;
        $retval = false;
        $query = $connection->prepare("UPDATE user SET PW_HASH=:pw_hash WHERE email=:email");
        $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);

        try {
            $connection->beginTransaction();
            $query->execute();
            $connection->commit();
            $retval = true;
        } catch(PDOExecption $e) {
            $connection->rollback();
            print($e->getMessage());
        }
    return $retval;
    }

    function getAllUsers() {
        global $connection;
        $query = $connection->prepare("SELECT u.id, u.vorname, u.nachname, r.name as role FROM user u LEFT JOIN roles r ON u.role_id=r.id");
        $query->execute();

        $retvalQueryArray = $query->fetchAll(PDO::FETCH_ASSOC);
        $retval = array();
        foreach ($retvalQueryArray as $role) {
            array_push($retval, $role);
        }

    return $retval;
    }

    function getUserByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT id, vorname, nachname, role_id FROM user WHERE id=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();

        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

    function updateUser($id, $role_id, $vorname, $nachname) {
        global $connection;
        $retval = false;

        $query = $connection->prepare("UPDATE user SET role_id =:role_id, vorname =:vorname, nachname=:nachname WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("role_id", $role_id, PDO::PARAM_STR);
        $query->bindParam("vorname", $vorname, PDO::PARAM_STR);
        $query->bindParam("nachname", $nachname, PDO::PARAM_STR);

        try {
            $connection->beginTransaction();
            $query->execute();
            $connection->commit();
            $retval = true;
        } catch(PDOExecption $e) {
            $connection->rollback();
            print($e->getMessage());
        }
        return $retval;
    }

    function deleteUser($id) {
        global $connection;
        $query = $connection->prepare("DELETE FROM users WHERE id=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }
?>
