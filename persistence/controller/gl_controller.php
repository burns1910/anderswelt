 <?php

    function addGLPlatz($va_id, $name, $plus, $type) {
        global $connection;

        $query = $connection->prepare("INSERT INTO gaesteliste(VA_ID,NAME,PLUS,TYPE) VALUES (:va_id,:name,:plus,:type)");
        $query->bindParam("va_id", $va_id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("plus", $plus, PDO::PARAM_STR);
        $query->bindParam("type", $type, PDO::PARAM_STR);
        
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

    function updateGLPlatz($id, $name, $plus, $type) {
        global $connection;
        $retval = false;
        $query = $connection->prepare("UPDATE gaesteliste SET NAME =:name, PLUS =:plus, TYPE =:type WHERE id = :id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("plus", $plus, PDO::PARAM_STR);
        $query->bindParam("type", $type, PDO::PARAM_STR);

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

    function getAllListGLPlaetzeByVAID($va_id) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM gaesteliste WHERE va_id =:va_id");
        $query->bindParam("va_id", $va_id, PDO::PARAM_STR);
        $query->execute();
 
        $retvalQueryArray = $query->fetchAll(PDO::FETCH_ASSOC);
        $retval = array();
        foreach ($retvalQueryArray as $zeile) {
            array_push($retval, $zeile);
        }

    return $retval;
    }

    function glTypString($typ) {
        switch ($typ) {
            case '0':
                $retval = "Besteliste";
                break;
            case '1':
                $retval = "Halfprice";
                break;
            case '2':
                $retval = "Schneggoliste";
                break;
            default:
                $retval = "";
                break;
        }
    return $retval;
    }

    function getGLPlatzByID($id) {
        global $connection;
        $query = $connection->prepare("SELECT * FROM gaesteliste WHERE ID=:id");
        $query->bindParam("id", $id, PDO::PARAM_STR);
        $query->execute();
 
        $retval = $query->fetch(PDO::FETCH_ASSOC);
    return $retval;
    }

    function getAmountOf($va_id, $gl_type) {
        global $connection;
        $query = $connection->prepare("SELECT COUNT(ID) AS anzahl FROM gaesteliste WHERE VA_ID=:va_id AND TYPE=:type");
        $query->bindParam("va_id", $va_id, PDO::PARAM_STR);
        $query->bindParam("type", $gl_type, PDO::PARAM_STR);
        $query->execute();
 
        $single = $query->fetch(PDO::FETCH_ASSOC);

        $query = $connection->prepare("SELECT SUM(PLUS) AS anzahl FROM gaesteliste WHERE VA_ID=:va_id AND TYPE=:type AND PLUS>0");
        $query->bindParam("va_id", $va_id, PDO::PARAM_STR);
        $query->bindParam("type", $gl_type, PDO::PARAM_STR);
        $query->execute();
 
        $plus = $query->fetch(PDO::FETCH_ASSOC);

        $retval = $single['anzahl'] + $plus['anzahl'];
    return $retval;
    }

?>