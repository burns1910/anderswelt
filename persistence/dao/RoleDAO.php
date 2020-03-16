<?php

include BASE_PATH.'/persistence/model/Role.php';

class RoleDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function listRoles() {
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value

    $searchArray = array();

    ## Search
    $searchQuery = " ";
    if($searchValue != ''){
       $searchQuery = " AND name LIKE :name ";
       $searchArray = array(
            'name'=>"%$searchValue%"
       );
    }

    ## Total number of records without filtering
    $stmt = $this->connection->prepare("SELECT COUNT(*) AS allcount FROM roles ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $stmt = $this->connection->prepare("SELECT COUNT(*) AS allcount FROM roles WHERE 1 ".$searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $stmt = $this->connection->prepare("SELECT * FROM roles WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

    // Bind values
    foreach($searchArray as $key=>$search){
       $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $roleRecords = $stmt->fetchAll();

    $data = array();

    foreach($roleRecords as $row){
       $data[] = array(
          "id"=>$row['id'],
          "name"=>$row['name'],
          "update"=>'<button type="button" name="update" id="'.$row["id"].'" class="btn btn-light btn-xs update">Bearbeiten</button>',
          "delete"=>'<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-light btn-xs delete" >L&ouml;schen</button>'
       );
    }

    ## Response
    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordwithFilter,
       "aaData" => $data
    );

    echo json_encode($response);
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
      $this->removePermission($roleId, $permissionId);
    }
    foreach ($toAdd as $permissionId) {
      $this->addPermission($roleId, $permissionId);
    }
  }

  public function addPermission($roleId, $permissionId) {
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

  public function removePermission($roleId, $permissionId) {
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
