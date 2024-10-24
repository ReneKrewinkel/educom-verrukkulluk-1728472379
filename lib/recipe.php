<?php

class Recipe {
    
    private $connection;
    private $use;
    private $ing;
    private $kt;
    private $BFOW;

    public function __construct($connection) {
        # Establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> use    = new user($this -> connection);
        $this -> ing    = new ingredient($this -> connection);
        $this -> kt     = new kitchenType($this -> connection);
        $this -> BFOW   = new BFOW($this -> connection);
    }

    public function selecteerRecipe($gerecht_id = null) {
        $sql = "select * from gerecht";
        if ($gerecht_id) {
            $sql .= " where id = $gerecht_id";
        }

        $result = mysqli_query($this->connection, $sql) or die(mysqli_error($this -> connection));
        $recipesComplete = [];

        while ($recipe = $result->fetch_assoc()){
             $user =         $this -> getUser($recipe["user_id"]);
             $kitchen =      $this -> selectKitchen($this -> getKT($recipe["keuken_id"]));
             $type =         $this -> selectType($this -> getKT($recipe["type_id"]));
             $ingridients =  $this -> getIngredient($recipe["id"]);
             $calories =     $this -> calcCalorieen($ingridients);
             $price =        $this -> calcPrice($ingridients);
             $rating =       $this -> calcStars($this -> getBFOW($recipe["id"], "W"));
             $steps =        $this -> selectSteps($this -> getBFOW($recipe["id"], "B"));
             $remarks =      $this -> selectRemarks($this -> getBFOW($recipe["id"], "O"));
             $favorite =     $this -> determineFavorite($this -> getBFOW($recipe["id"], "F"));

             $recipeComplete = [
                "recipe"            => $recipe,
                "user"              => $user,
                "calories"          => $calories,
                "price"             => $price,
                "rating"            => $rating,
                "kitchen"           => $kitchen,
                "type"              => $type,
                "favorite"          => $favorite,
                "ingridients"       => $ingridients,
                "steps"             => $steps,
                "remarks"           => $remarks
            ];

            $recipesComplete[] = $recipeComplete;
        }

        return $recipesComplete;
    }

    # Connecting classes
    private function getUser($user_id) {
        $useData = $this -> use -> selecteerUser($user_id); 
        return($useData);
    }

    private function getIngredient($gerecht_id) {
        $ingData = $this -> ing -> selecteerIngredient($gerecht_id); 
        return($ingData);
    }

    private function getBFOW($gerecht_id, $BFOW) {
        $BFOWData = $this -> BFOW -> selecteerBFOW($gerecht_id, $BFOW); 
        return($BFOWData);
    }

    private function getKT($kt_id) {
        $KTData = $this -> kt -> selecteerKT($kt_id);
        return($KTData);
    }

    # Calculating information
    private function calcCalorieen($ingData) {
        $cal_sum = 0;
        foreach ($ingData as $ingridient) {
            $cal_sum += $ingridient['calorieen'] / $ingridient['verpakking'] * $ingridient['aantal'];
        }
        return($cal_sum);
    }

    # Price per recipe their used ingridients, price for collection articles later
    private function calcPrice($ingData) {
        $price_sum = 0;
        foreach ($ingData as $ingridient) {
            $price_sum += ($ingridient['aantal'] / $ingridient['verpakking']) * $ingridient['prijs'];
        }
        return($price_sum);
    }

    private function calcStars($BFOWData) {
        $star_sum = 0;
        $nr = 0;
        foreach ($BFOWData as $star) {
            $star_sum += $star["numeriek_veld"];
            $nr += 1;
        }
        $nr_stars = $star_sum / $nr;
        return($nr_stars); 
    }

    private function selectSteps($BFOWData) {
        $steps = [];
        foreach ($BFOWData as $step) {
            $steps[] = $step["tekst_veld"];
        }

        // # Hier wordt een array in een array geplaatst zodat elk tekstvalk ook een nummer krijgt, 
        // # mocht dit nodig zijn
        // $preperationMethod = [];
        // $desired_columns = ["numeriek_veld", "tekst_veld"];
        // foreach ($BFOWData as $row1) {
        //     $row2 = [];
        //     foreach ($desired_columns as $column) {
        //         $row2[$column] = $row1[$column];
        //     }
        //     $preperationMethod[] = $row2;
        // }
        return $steps;
    }

    private function selectRemarks($BFOWData){
        $remarks = [];
        $desired_columns = ["afbeelding", "user_name", "tekst_veld"];
        foreach ($BFOWData as $remark) {
            $row = [];
            foreach ($desired_columns as $column) {
                $row[$column] = $remark[$column];
            }
            $remarks[] = $row;
        }
        return $remarks;
    }

    private function selectKitchen($KTData){
        return($KTData["omschrijving"]);
    }

    private function selectType($KTData) {
        return($KTData["omschrijving"]);
    }

    private function determineFavorite($BFOWData){
        return $BFOWData;
    }
}