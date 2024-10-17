<?php

class boodschappenToevoegen {

    private $connection;
    private $use;
    private $ing;

    private $arrayA;        # Aantal verpakkingen nodig
    private $arrayB;        # Boodschappen
    private $arrayN;        # Hoeveelheid ingredienten nodig
    #private $arrayCompleet; # combinatie van array A, B en N
    

    public function __construct($connection) {
        # Establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> use    = new user($this -> connection);
        $this -> ing    = new ingredient($this -> connection);
        $this -> arrayA = [];
        $this -> arrayB = [];
        $this -> arrayN = [];
    }
  
    public function boodschappenToevoegen($gerecht_id, $user_id = 1) {
        $ingridients =  $this -> getIngredient($gerecht_id);
        #var_dump($ingridients);
        $desired_columns = ["artikel_id", "naam", "prijs", "verpakking"]; 

        #var_dump($desired_columns);
        foreach ($ingridients as $ingredient){
            foreach ($desired_columns as $column) {
                    $rowB[$column] = $ingredient[$column];
            }
            $rowN = (float)$ingredient["aantal"];


            if (!in_array($rowB, $this -> arrayB)){# ingredient nog niet op de lijst) {
                $this -> arrayB[] = $rowB;
                $this -> arrayN[] = $rowN;
                $this -> arrayA[] = 1;
            } else {
                echo "<br>";
                $i = 0;
                foreach($this -> arrayB as $row) {
                    if ($rowB["artikel_id"] == $row["artikel_id"]){
                        $this -> arrayN[$i] += (int)$ingredient["aantal"];

                        while ($this -> arrayA[$i] * $row["verpakking"] < $this -> arrayN[$i]){
                            $this -> arrayA[$i] += 1;
                            # kan ook met een formule en simpelweg vervangen
                            # totaal hoeveelheid nodig / in verpakking naar boven afronden
                        }
                        break;
                    }
                    $i += 1;
                }
            }
        }
    }

    public function combineArrays(){
        $combinedArray = [];
        foreach ($this -> arrayB as $key => $item) {
            $combinedItem = [
                "artikel_id" => $item["artikel_id"],
                "naam"       => $item["naam"],
                "prijs"      => $item["prijs"],
                "verpakking" => $item["verpakking"],
                "aantal"     => $this -> arrayA[$key],
                "nodig"      => $this -> arrayN[$key] 
            ];
            $combinedArray[] = $combinedItem;
        }
        return $combinedArray;
    }

    public function getBoodschappenlijst(){
        return $this -> arrayB;
    }

    public function getNodig(){
        return $this -> arrayN;
    }

    public function getAantal(){
        return $this -> arrayA;
    }

    public function clearBoodschappenlijst(){
        $this -> arrayB = [];
    }

    private function getIngredient($gerecht_id) {
        $ingData = $this -> ing -> selecteerIngredient($gerecht_id); 
        return($ingData);
    }


}
