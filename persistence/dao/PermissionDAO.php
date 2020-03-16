<?php

include BASE_PATH.'/persistence/model/Permission.php';

class PermissionDAO {

  private $connection;

  function __construct($connection) {
    $this->connection = $connection;
  }

  public function listPermissions() {
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
    $stmt = $this->connection->prepare("SELECT COUNT(*) AS allcount FROM permissions ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $stmt = $this->connection->prepare("SELECT COUNT(*) AS allcount FROM permissions WHERE 1 ".$searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $stmt = $this->connection->prepare("SELECT * FROM permissions WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

    // Bind values
    foreach($searchArray as $key=>$search){
       $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $permRecords = $stmt->fetchAll();

    $data = array();

    foreach($permRecords as $row){
       $data[] = array(
          "id"=>$row['id'],
          "name"=>$row['name'],
          "update"=>'<a href="#" id="'.$row["id"].'" class="update"><i class="fas fa-edit" aria-hidden="true"></i></a>',
          "delete"=>'<a href="#" id="'.$row["id"].'" class="delete"><i class="fas fa-trash" aria-hidden="true"></a>'
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

}
?>
