<?php

    function addRole($name, $description) {
        global $connection;
        $query = $connection->prepare("INSERT INTO roles(NAME,DESCRIPTION) VALUES (:name,:description)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("description", $description,PDO::PARAM_STR);
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

    function updateRole($role_id, $name, $description) {
        global $connection;
        $retval = false;
        $query = $connection->prepare("UPDATE roles SET NAME=:name, DESCRIPTION=:description WHERE id=:role_id");
        $query->bindParam("role_id", $role_id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("description", $description, PDO::PARAM_STR);

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

    function deleteRole($id) {
        global $connection;
        $query = $connection->prepare("DELETE FROM roles WHERE id=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
    }

    function getAllRoles() {
        global $connection;
        $query = $connection->prepare("SELECT * FROM roles");
        $query->execute();

        $retvalQueryArray = $query->fetchAll(PDO::FETCH_ASSOC);
        $retval = array();
        foreach ($retvalQueryArray as $role) {
            array_push($retval, $role);
        }

        return $retval;
    }

    function getRoleByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM roles WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();

        $retval = $query->fetch(PDO::FETCH_ASSOC);
        return $retval;
    }

    function getRoleNameByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT name FROM roles WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();

        $retval = $query->fetch(PDO::FETCH_ASSOC);
        return $retval;
    }

?>