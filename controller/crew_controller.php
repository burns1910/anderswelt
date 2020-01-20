<?php

    function listeAllerCrewMember() {
        global $connection;
        $query = $connection->prepare("SELECT * FROM crew_member");
        $query->execute();
 
        $i = 0; 
        while($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $retval[$i] = $result;
            $i++;
        }
    return $retval;
    }

    function getDataFromCrewMemberByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM crew_member WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

    function getMailFromCrewMemberByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT email FROM crew_member WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
 
        $mail = $query->fetch(PDO::FETCH_ASSOC);
        $retval = $mail['email'];
    return $retval;
    }

    function addCrewMember($name, $email, $telefon, $kommentar) {
        global $connection;
        
        $query = $connection->prepare("INSERT INTO crew_member(NAME,EMAIL,TELEFON,KOMMENTAR) VALUES (:name,:email,:telefon,:kommentar)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("telefon", $telefon, PDO::PARAM_STR);
        $query->bindParam("kommentar", $kommentar, PDO::PARAM_STR);
        
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

    function doesCrewMemberExist($email) {
        global $connection;
        $retval = false;

        $query = $connection->prepare("SELECT * FROM crew_member WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount() > 0) {
            $retval = true;
        }
    return $retval;
    }

    function updateCrewMember($id, $name, $email, $telefon, $kommentar) {
        global $connection;
        $retval = false;

        $query = $connection->prepare("UPDATE crew_member SET NAME =:name, EMAIL =:email, TELEFON=:telefon, KOMMENTAR=:kommentar WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("telefon", $telefon, PDO::PARAM_STR);
        $query->bindParam("kommentar", $kommentar, PDO::PARAM_STR);

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
?>