<?php

    function addToken($email, $selector, $token, $token_expire_date) {
        global $connection;

        $query = $connection->prepare("INSERT INTO pw_reset(EMAIL,SELECTOR,TOKEN,TOKEN_EXPIRE_DATE) VALUES (:email,:selector,:token,:token_expire_date)");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("selector", $selector, PDO::PARAM_STR);
        $query->bindParam("token", $token, PDO::PARAM_STR);
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

    function deleteTokenByEMail($email) {
        global $connection;
        $query = $connection->prepare("DELETE FROM pw_reset WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    }

    function getTokenExpireDateByEmail($email) {
        global $connection;
        $retval = 0;

        $query = $connection->prepare("SELECT token_expire_date FROM pw_reset WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $date = $result['token_expire_date'];
        $retval = strtotime($date);
    return $retval;
    }

    function getMailBySelector($selector) {
        global $connection;
        $retval = 0;

        $query = $connection->prepare("SELECT email FROM pw_reset WHERE SELECTOR=:selector");
        $query->bindParam("selector", $selector, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $retval = $result['email'];
    return $retval;
    }

    function getToken($selector) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM pw_reset WHERE SELECTOR=:selector");
        $query->bindParam("selector", $selector, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

?>