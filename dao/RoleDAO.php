<?php

include BASE_PATH.'/model/Role.php';

class RoleDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function getRoleByID($id) {
    try {
      $query = $this->connection->prepare("SELECT * FROM roles WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "Role");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function getAllRoles() {
    try {
      $query = $this->connection->prepare("SELECT * FROM roles");
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "Role");
      return $obj = $query->fetchAll();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function addRole($name, $description) {
    try {
      $query = $this->connection->prepare("INSERT INTO roles(NAME,DESCRIPTION) VALUES (:name,:description)");
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

  function updateRole($id, $name, $description) {
    try {
      $query = $this->connection->prepare("UPDATE roles SET NAME=:name, DESCRIPTION=:description WHERE id=:id");
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

  public function deleteRole($id) {
    try {
      $query = $this->connection->prepare("DELETE FROM roles WHERE id=:id");
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
