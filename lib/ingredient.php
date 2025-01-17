<?php

#require_once("lib/artikel.php");
class ingredient {
    
    private $connection;
    private $art;

    public function __construct($connection) {
        # establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> art = new artikel($this -> connection);
    }
  
    public function selecteerIngredient($gerecht_id) {
        // echo "<pre>";
        // var_dump($this->connection);
        $sql = "select * from ingredieent where gerecht_id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        
        $collection_ingredients = [];
        if ($result -> num_rows > 0) {
            while ($ingredient = $result->fetch_assoc()){
                # Makes the result readable

                # Uses the private function to obtain alle articles
                $artData = $this -> GetArticle($ingredient["artikel_id"]);

                # Leave out "id" from artiekelen
                $desired_columns = ["naam", "omschrijving", "prijs", "eenheid", "verpakking", "calorieen"];
                $filtered_row = [];

                foreach ($desired_columns as $column) {
                    $filtered_row[$column] = $artData[$column];
                }
                
                $merged_array = array_merge($ingredient, $filtered_row);
                $collection_ingredients[] = $merged_array;
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
