<?php

require_once("lib/user.php");
class Recipe {
    
    private $connection;
    private $db;
    private $use;
    private $ing;           # Later bijgevoegd
    private $kt;            # Later bijgevoegd
    private $BFOW;          # Later bijgevoegd

    public function __construct($connection) {
        # Establishes a connection with the database and the artikel class
        $this -> connection = $connection;
        $this -> db     = new database();
        $this -> use    = new user($this -> db -> getConnection());
        $this -> ing    = new ingredient($this -> db -> getConnection());
        $this -> kt     = new kitchenType($this -> db -> getConnection());
        $this -> BFOW   = new BFOW($this -> db -> getConnection());
    }

    public function selecteerRecipe($gerecht_id, $user_id = 1) {
        $sql = "select * from gerecht where id = $gerecht_id"; # "select * from gerecht where id = $gerecht_id";
        $result = mysqli_query($this->connection, $sql);
        $gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user =         $this -> getUser($gerecht["user_id"]);
        $ingridients =  $this -> getIngredient($gerecht_id);
        $calories =     $this -> calcCalorieen($ingridients);
        $price =        $this -> calcPrice($ingridients);
        $rating =       $this -> calcStars($this -> getBFOW($gerecht_id, "W"));
        $bereidingswijze = $this -> selectSteps($this -> getBFOW($gerecht_id, "B"));
        $opmerkingen =  $this -> selectRemarks($this -> getBFOW($gerecht_id, "O"));
        $keuken =       $this -> selectKitchen($this -> getKT($gerecht["keuken_id"]));
        $type =         $this -> selectType($this -> getKT($gerecht["type_id"]));
        $favorite =     $this -> determineFavorite($this -> getBFOW($gerecht_id, "F"));

        $gerechtCompleet = [
            "User information"      => $user,
            "Hoeveelheid calorieen" => $calories,
            "Prijs"                 => $price,
            "Rating"                => $rating,
            "Keuken"                => $keuken,
            "Type"                  => $type,
            "Favoriet"              => $favorite,
            "Ingrident"             => $ingridients,
            "Bereidigswijze"        => $bereidingswijze,
            "Opmerkingen"           => $opmerkingen
        ];

        return($gerechtCompleet);
    }

    # Classes linken
    private function getUser($user_id) {
        $useData = $this -> use -> selecteerUser($user_id); 
        return($useData);
    }

    private function getIngredient($gerecht_id) {
        $ingData = $this -> ing -> selecteerIngredient($gerecht_id); 
        return($ingData);
    }

    private function getBFOW($gerechtOrUser_id, $BFOW) {
        $BFOWData = $this -> BFOW -> selecteerBFOW($gerechtOrUser_id, $BFOW); 
        return($BFOWData);
    }

    private function getKT($kt_id) {
        $KTData = $this -> kt -> selecteerKT($kt_id);
        return($KTData);
    }

    # Let op, er zijn ingredienten die later zijn toegevoegd, zorg dat je alle rijen ziet
    # Calculating information
    private function calcCalorieen($ingData) {
        $cal_sum = 0;
        foreach ($ingData as $ingridient) {
            $cal_sum += $ingridient['calorieen'] / $ingridient['verpakking'] * $ingridient['aantal'];
        }
        return($cal_sum);
    }

    # Let op, er zijn ingredienten die later zijn toegevoegd, zorg dat je alle rijen ziet
    # Dit is echt de prijs per gerecht, prijs voor elk artiekel komt pas aan bod in boodschappenlijstje
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
        // foreach ($BFOWData as $favorite) {
        //     if ($favorite["gerecht_id"] == $gerecht_id){
        //         $user_id = $favorite['user_id'];
        //         #return "Gerecht $gerecht_id is a favorite of user $user_id";
        //     }
        // }
    }
}