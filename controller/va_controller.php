<?php

    function addVeranstaltung($titel, $start, $ende, $header) {
        global $connection;

        $query = $connection->prepare("INSERT INTO veranstaltung(TITEL, START, ENDE, HEADER) VALUES (:titel,:start,:ende, :header)");
        $query->bindParam("titel", $titel, PDO::PARAM_STR);
        $query->bindParam("start", $start, PDO::PARAM_STR);
        $query->bindParam("ende", $ende, PDO::PARAM_STR);
        $query->bindParam("header", $header, PDO::PARAM_STR);

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

    function getAnstehendeVA() {
        global $connection;
        $retval = null;
        $query = $connection->prepare("SELECT * FROM veranstaltung WHERE ende>NOW()");
        $query->execute();

        $i = 0;
        while($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $retval[$i] = $result;
            $i++;
        }
    return $retval;
    }

    function getVAByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM veranstaltung WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();

        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

?>
