<?php

require_once("lib/user.php");
class BFOW {
    
    private $connection;
    private $db;
    private $use;

    public function __construct($connection) {
        # Establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> db = new database();
        $this -> use = new user($this -> db->getConnection());
    }

    public function selecteerBFOW($gerechtOrUser_id, $BFOW) {
        $sql = "select * from gerecht_info where record_type = '$BFOW' and ";
        if ($BFOW != "F") {
            $sql .= "gerecht_id = $gerechtOrUser_id";
        } else {
            $sql .= "user_id = '$gerechtOrUser_id'";
        }
        echo $sql;
        $result = mysqli_query($this->connection, $sql);
      
        if ($result -> num_rows > 0) {
            while ($gerecht_info = $result -> fetch_assoc()){
                
                echo "<pre>"; 
                if ($BFOW == "F" or $BFOW == "O") {
                    # Uses the private function to retreive the user's data
                    $useData = $this -> getUser($gerecht_info["user_id"]);
                    $merged_array = array_merge($gerecht_info, $useData);
                    $collection_users[] = $merged_array;
                }
                else {
                    $collection_users[] = $gerecht_info;
                }
            }
        }
        return($collection_users);
    }

    private function getUser($user_id) {
    $useData = $this -> use -> selecteerUser($user_id); 
    return($useData);
    }
}