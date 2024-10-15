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

    # Deze haalt alle info op
    public function selecteerBFOW($gerechtOrUser_id, $BFOW) {
        // $sql = "select * from gerecht_info where record_type = '$BFOW' and ";
        // if ($BFOW != "F") {
        //     $sql .= "gerecht_id = $gerechtOrUser_id";
        // } else {
        //     $sql .= "user_id = '$gerechtOrUser_id'";
        // }
        $sql = "select * from gerecht_info where record_type = '$BFOW' and gerecht_id = $gerechtOrUser_id";
        
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

    # Deze past de database aan
    public function setFavorite($gerecht_id, $user_id = 1, $add_remove = "To be determined"){
        if ($add_remove == "add") {
            $this -> addFavorite($gerecht_id, $user_id);
        } else if ($add_remove == "remove") {
            $this -> deleteFavorite($gerecht_id, $user_id);
        }
    }

    private function addFavorite($gerecht_id, $user_id) {
        $sql = "INSERT INTO gerecht_info (gerecht_id, record_type, user_id) VALUES ($gerecht_id, 'F', $user_id)";
        $result = mysqli_query($this->connection, $sql);
        var_dump($result);
    }

    private function deleteFavorite($gerecht_id, $user_id) {
        $sql = "DELETE FROM gerecht_info WHERE gerecht_id = $gerecht_id AND record_type = 'F' AND user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        var_dump($result);
    }

}