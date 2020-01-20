<?php

    function addListe($name, $beschreibung) {
        global $connection;

        $query = $connection->prepare("INSERT INTO crew_liste(NAME,BESCHREIBUNG) VALUES (:name,:beschreibung)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("beschreibung", $beschreibung, PDO::PARAM_STR);
        
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

    function updateListe($id, $name, $beschreibung) {
        global $connection;
        $retval = false;
        $query = $connection->prepare("UPDATE crew_liste SET NAME =:name, BESCHREIBUNG =:beschreibung WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("beschreibung", $beschreibung, PDO::PARAM_STR);

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

    function listeAllerCrewlisten() {
        global $connection;
        $query = $connection->prepare("SELECT * FROM crew_liste");
        $query->execute();
 
        $i = 0; 
        while($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $retval[$i] = $result;
            $i++;
        }
    return $retval;
    }

    function listeAllerHashtags() {
        global $connection;
        $query = $connection->prepare("SELECT * FROM hashtags");
        $query->execute();
 
        $i = 0; 
        while($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $retval[$i] = $result;
            $i++;
        }
    return $retval;
    }

    function getDataFromCrewListeByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM crew_liste WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

    function addCrewMembersToList($crew_member_ids, $list_id) {
        global $connection;
        foreach ($crew_member_ids as $crew_member_id) {
            $query = $connection->prepare("INSERT INTO crew_listen_member(LIST_ID,CREW_MEMBER_ID) VALUES (:list_id,:crew_member_id)");
            $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
            $query->bindParam("crew_member_id", $crew_member_id, PDO::PARAM_STR);
            $query->execute();
        }
    }

    function addCrewMemberToLists($crew_member_id, $list_ids) {
        global $connection;
        foreach ($list_ids as $list_id) {
            $query = $connection->prepare("INSERT INTO crew_listen_member(LIST_ID,CREW_MEMBER_ID) VALUES (:list_id,:crew_member_id)");
            $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
            $query->bindParam("crew_member_id", $crew_member_id, PDO::PARAM_STR);
            $query->execute();
        }
    }

    function deleteCrewMemberFromLists($crew_member_id, $list_ids) {
        global $connection;
        foreach ($list_ids as $list_id) {
            $query = $connection->prepare("DELETE FROM crew_listen_member WHERE list_id=:list_id AND crew_member_id=:crew_member_id");
            $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
            $query->bindParam("crew_member_id", $crew_member_id, PDO::PARAM_STR);
            $query->execute();
        }
    }

    function deleteCrewMembersFromList($crew_member_ids, $list_id) {
        global $connection;
        foreach ($crew_member_ids as $crew_member_id) {
            $query = $connection->prepare("DELETE FROM crew_listen_member WHERE list_id=:list_id AND crew_member_id=:crew_member_id");
            $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
            $query->bindParam("crew_member_id", $crew_member_id, PDO::PARAM_STR);
            $query->execute();
        }
    }

    function getAllListIDsFromCrewMember($crew_member_id) {
        global $connection;
        $query = $connection->prepare("SELECT list_id FROM crew_listen_member WHERE crew_member_id =:crew_member_id");
        $query->bindParam("crew_member_id", $crew_member_id, PDO::PARAM_STR);
        $query->execute();
 
        $retvalQueryArray = $query->fetchAll(PDO::FETCH_ASSOC);
        $retval = array();
        foreach ($retvalQueryArray as $zeile) {
            array_push($retval, $zeile['list_id']);
        }

    return $retval;
    }

    function getAllMemberIDsFromList($list_id) {
        global $connection;
        $query = $connection->prepare("SELECT crew_member_id FROM crew_listen_member WHERE list_id =:list_id");
        $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
        $query->execute();
 
        $retvalQueryArray = $query->fetchAll(PDO::FETCH_ASSOC);
        $retval = array();
        foreach ($retvalQueryArray as $zeile) {
            array_push($retval, $zeile['crew_member_id']);
        }

    return $retval;
    }

    function getAllMemberDataFromList($list_id) {
        global $connection;
        $query = $connection->prepare("SELECT crew_member.* FROM crew_member, crew_listen_member WHERE crew_listen_member.list_id = :list_id AND crew_listen_member.crew_member_id = crew_member.id");
        $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetchAll(PDO::FETCH_ASSOC);

    return $retval;
    }

    function getAllMemberDataFromListSortedByHashtag($list_id, $hashtag) {
        global $connection;
        $pattern = '%'.$hashtag.'%';
        $query = $connection->prepare("SELECT crew_member.* FROM crew_member, crew_listen_member WHERE crew_listen_member.list_id = :list_id AND crew_listen_member.crew_member_id = crew_member.id AND crew_member.kommentar LIKE :hashtag");
        $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
        $query->bindParam("hashtag", $pattern, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetchAll(PDO::FETCH_ASSOC);

    return $retval;
    }

    function getAllMemberDataByTag($hashtag) {
        global $connection;
        $pattern = '%'.$hashtag.'%';
        $query = $connection->prepare("SELECT * FROM crew_member WHERE kommentar LIKE :hashtag");
        $query->bindParam("hashtag", $pattern, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetchAll(PDO::FETCH_ASSOC);

    return $retval;
    }

?>