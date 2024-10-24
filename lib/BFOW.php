<?php

#require_once("lib/user.php");
class BFOW {
    
    private $connection;
    private $use;

    public function __construct($connection) {
        # Establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> use = new user($this -> connection);
    }

    # Function to retrieve all data
    public function selecteerBFOW($gerecht_id, $BFOW) {
        $sql = "select * from gerecht_info where record_type = '$BFOW' and gerecht_id = $gerecht_id";
        
        $result = mysqli_query($this->connection, $sql);
        
        if ($result -> num_rows > 0) {
            while ($recipe_info = $result -> fetch_assoc()){
                if ($BFOW == "F" or $BFOW == "O") {
                    # Uses the private function to retreive the user's data
                    $useData = $this -> getUser($recipe_info["user_id"]);
                    $merged_array = array_merge($recipe_info, $useData);
                    $collection[] = $merged_array;
                }
                else {
                    $collection[] = $recipe_info;
                }
            }
        }
        return($collection);
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