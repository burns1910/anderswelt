<?php

include BASE_PATH.'/persistence/model/User.php';
include BASE_PATH.'/persistence/dao/RoleDAO.php';

class UserDAO {

  private $connection;
  private $roleDao;

  function __construct($connection) {
    $this->connection = $connection;
    $this->roleDao = new RoleDAO($connection);
  }

  public function listUsers() {
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
       $searchQuery = " AND (vorname LIKE :vorname OR
         nachname LIKE :nachname OR
         email LIKE :email ) ";
       $searchArray = array(
            'vorname'=>"%$searchValue%",
            'nachname'=>"%$searchValue%",
            'email'=>"%$searchValue%"
       );
    }

    ## Total number of records without filtering
    $stmt = $this->connection->prepare("SELECT COUNT(*) AS allcount FROM user ");
    $stmt->execute();
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $stmt = $this->connection->prepare("SELECT COUNT(*) AS allcount FROM user WHERE 1 ".$searchQuery);
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $stmt = $this->connection->prepare("SELECT * FROM user WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

    // Bind values
    foreach($searchArray as $key=>$search){
       $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $userRecords = $stmt->fetchAll();

    $data = array();

    foreach($userRecords as $row){
      if(isset($row['role_id']) && !empty($row['role_id'])) {
    		if ( array_key_exists('role_id', $row)) {
          $role = $this->roleDao->getRoleByID($row['role_id']);
          $role_name = $role->getName();
    		}
    	} else {
        $role_name = "-";
      }
       $data[] = array(
          "id"=>$row['id'],
          "vorname"=>$row['vorname'],
          "nachname"=>$row['nachname'],
          "email"=>$row['email'],
          "role"=>$role_name,
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

  public function getUserByID($id) {
    try {
      $query = $this->connection->prepare("SELECT * FROM user WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function getUserByEmail($email) {
    try {
      $query = $this->connection->prepare("SELECT * FROM user WHERE email=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      return $obj = $query->fetch();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function getAllUsers() {
    try {
      $query = $this->connection->prepare("SELECT u.id, u.vorname, u.nachname, u.email, r.name as role FROM user u LEFT JOIN roles r ON u.role_id=r.id");
      $query->execute();
      $query->setFetchMode(PDO::FETCH_CLASS, "User");
      return $obj = $query->fetchAll();
    }
    catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function addUser($vorname, $nachname, $email, $token, $pw_hash, $token_expire_date) {
    try {
      $query = $this->connection->prepare("INSERT INTO user(VORNAME,NACHNAME,EMAIL,TOKEN,PW_HASH,TOKEN_EXPIRE_DATE) VALUES (:vorname,:nachname,:email,:token,:pw_hash,:token_expire_date)");
      $query->bindParam("vorname", $vorname, PDO::PARAM_STR);
      $query->bindParam("nachname", $nachname, PDO::PARAM_STR);
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->bindParam("token", $token, PDO::PARAM_STR);
      $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
      $query->bindParam("token_expire_date", $token_expire_date, PDO::PARAM_STR);
      $query->execute();
      $id = $this->connection->lastInsertID();
      return $id;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  function updateUser($id, $role_id, $vorname, $nachname, $email, $pw_hash) {
    try {
      $query = $this->connection->prepare("UPDATE user SET role_id =:role_id, vorname =:vorname, nachname=:nachname, email=:email, pw_hash=:pw_hash WHERE id = :id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->bindParam("role_id", $role_id, PDO::PARAM_STR);
      $query->bindParam("vorname", $vorname, PDO::PARAM_STR);
      $query->bindParam("nachname", $nachname, PDO::PARAM_STR);
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
      $query->execute();
      $updated = $query->rowCount();
      return $updated;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

//TODO: Service Layer für kombinierte Hilfsmethoden implementieren
  public function updatePWByMail($email, $pw_hash) {
    try {
      $query = $this->connection->prepare("UPDATE user SET pw_hash=:pw_hash WHERE email=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->bindParam("pw_hash", $pw_hash, PDO::PARAM_STR);
      $query->execute();
      $updated = $query->rowCount();
      return $updated;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function deleteUser($id) {
    try {
      $query = $this->connection->prepare("DELETE FROM user WHERE id=:id");
      $query->bindParam("id", $id, PDO::PARAM_STR);
      $query->execute();
      $deleted = $query->rowCount();
      return $deleted;
    } catch(PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
      return 0;
    }
  }

  public function doesUserExist($email) {
    $userExists = false;
    try {
      $query = $this->connection->prepare("SELECT 1 FROM user WHERE EMAIL=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
      if(strcmp($query->fetchColumn(), "1") == 0) {
        $userExists = true;
      }
    }
    catch (PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
    return $userExists;
  }

  public function verifyEmail($email) {
    try {
      $query = $this->connection->prepare("UPDATE user SET mail_verified='1' WHERE EMAIL=:email");
      $query->bindParam("email", $email, PDO::PARAM_STR);
      $query->execute();
    }
    catch (PDOException $e) {
      $_SESSION['error_msg'] = "Irgendwas ist schief gegangen :/";
    }
  }

}

?>
