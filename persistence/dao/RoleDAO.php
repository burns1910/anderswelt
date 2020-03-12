<?php

include BASE_PATH.'/persistence/model/Role.php';

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

  public function getPermissionIDsFromRole($roleId) {
    try {
      $query = $this->connection->prepare("SELECT permission_id FROM permission_role WHERE role_id=:roleId");
      $query->bindParam("roleId", $roleId, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_NUM);
      $retVal = array();
      while($obj = $query->fetch()) {
        $retVal[] = $obj[0];
      }
      return $retVal;
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function hasRolePermission($roleId, $permission) {
    try {
      $query = $this->connection->prepare("SELECT 1 FROM permission_role WHERE role_id=:roleId AND permission_id=:permission");
      $query->bindParam("roleid", $roleId, PDO::PARAM_STR);
      $query->bindParam("permission", $permission, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_NUM);
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

  public function updatePermissions($roleId, $permissions) {
    $oldPermissions = $this->getPermissionIDsFromRole($roleId);
    $toDelete = array_diff($oldPermissions, $permissions);
    $toAdd = array_diff($permissions, $oldPermissions);
    foreach ($toDelete as $permissionId) {
      $this->deletePermission($roleId, $permissionId);
    }
    foreach ($toAdd as $permissionId) {
      $this->addPermission($roleId, $permissionId);
    }
  }

  private function addPermission($roleId, $permissionId) {
    try {
      $query = $this->connection->prepare("INSERT INTO permission_role(ROLE_ID,PERMISSION_ID) VALUES (:roleId,:permissionId)");
      $query->bindParam("roleId", $roleId, PDO::PARAM_STR);
      $query->bindParam("permissionId", $permissionId,PDO::PARAM_STR);
      $query->execute();
      $id = $this->connection->lastInsertID();
      return $id;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  private function deletePermission($roleId, $permissionId) {
    try {
      $query = $this->connection->prepare("DELETE FROM permission_role WHERE role_id=:roleId AND permission_id=:permissionId");
      $query->bindParam("roleId", $roleId, PDO::PARAM_STR);
      $query->bindParam("permissionId", $permissionId, PDO::PARAM_STR);
      $query->execute();
      $deleted = $query->rowCount();
      return $deleted;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

}
?>
