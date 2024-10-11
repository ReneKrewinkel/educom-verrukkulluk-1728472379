<?php

require_once("lib/artikel.php");
class ingredient {
    
    private $connection;
    private $db;
    private $art;

    public function __construct($connection) {
        # establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> db = new database();
        $this -> art = new artikel($this -> db->getConnection());
    }
  
    public function selecteerIngredient($gerecht_id) {
        $sql = "select * from ingredieent where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        
        if ($result -> num_rows > 0) {
            while ($ingredient = $result->fetch_assoc()){
                # Makes the result readable
                echo "<pre>"; 

                # Uses the private function to obtain alle articles
                $artData = $this -> GetArticle($ingredient["artikel_id"]);
                
                # Collects all ingredients and articles
                $collection_ingredients[] = [$ingredient, $artData];
            }
        }
        return($collection_ingredients);

    }
    private function getArticle($article_id) {
    # Uses the function selecteerArtikel from class artiekel
    $artData = $this -> art -> selecteerArtikel($article_id); 
    return($artData);
    }

}
