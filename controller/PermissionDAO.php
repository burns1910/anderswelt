<?php

include BASE_PATH.'/model/Permission.php';

class PermissionDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function getPermissionByID($id) {
    try {
      $query = $this->connection->prepare("SELECT * FROM permissions WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "Permission");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function getAllPermissions() {
    try {
      $query = $this->connection->prepare("SELECT * FROM permissions");
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "Permission");
      return $obj = $query->fetchAll();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function addPermission($name, $description) {
    try {
      $query = $this->connection->prepare("INSERT INTO permissions(NAME,DESCRIPTION) VALUES (:name,:description)");
      $query->bindParam("name", $name, PDO::PARAM_STR);
      $query->bindParam("description", $description,PDO::PARAM_STR);
      $query->execute();
      $id = $this->connection->lastInsertID();
      return $id;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  function updatePermission($id, $name, $description) {
    try {
      $query = $this->connection->prepare("UPDATE permissions SET NAME=:name, DESCRIPTION=:description WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->bindParam("name", $name, PDO::PARAM_STR);
      $query->bindParam("description", $description, PDO::PARAM_STR);
      $query->execute();
      $updated = $query->rowCount();
      return $updated;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function deletePermission($id) {
    try {
      $query = $this->connection->prepare("DELETE FROM permissions WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $deleted = $query->rowCount();
      return $deleted;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

/*    function getAllRolesAsTable() {
      global $connection;
      $roleData = array();
      $numRows = 0;
      $sql = "SELECT COUNT(*) FROM roles";
      if ($res = $connection->query($sql)) {
        $numRows = $res->fetchColumn();
        if ($numRows > 0) {
          $sql = "SELECT * FROM roles";
          foreach ($connection->query($sql) as $role) {
            $roleRows = array();
            $roleRows[] = $role['id'];
            $roleRows[] = $role['name'];
            $roleRows[] = '<button type="button" name="update" id="'.$role["id"].'" class="btn btn-warning btn-xs update">Update</button>';
            $roleRows[] = '<button type="button" name="delete" id="'.$role["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
            $roleData[] = $roleRows;
          }
        }
      }
      $output = array(
      //  "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"  	=>  $numRows,
        "recordsFiltered" 	=> 	$numRows,
        "data"    			=> 	$roleData
      );
      echo json_encode($output);
    }
*/
}
?>
