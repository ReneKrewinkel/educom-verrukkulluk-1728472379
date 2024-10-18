<?php

class boodschappenToevoegenVolgensAlgoritme {

    private $connection;
    private $use;
    private $ing;

    public function __construct($connection) {
        $this -> connection = $connection;
        $this -> use    = new user($this -> connection);
        $this -> ing    = new ingredient($this -> connection);
    }
  
    public function boodschappenToevoegen_metFuncties($gerecht_id, $user_id = 1) {
        $this -> checkExistenceTable($gerecht_id);
        $ingridients = $this -> getIngredient($gerecht_id);

        foreach ($ingridients as $ingridient) {
            $artikel_id = $ingridient["artikel_id"];
            $check = $this -> ArtikelOpLijst($user_id, $artikel_id);

            if ($check == FALSE) {
                $this -> addArticleToList($ingridient, $user_id);
            } else {
                $ingredienten_nodig = $this -> hoeveelheidIngredientUpdaten($ingridient, $user_id);
                $this -> verpakkingUpdaten($artikel_id, $ingredienten_nodig, $user_id);
            }
        }
    }




    private function checkExistenceTable(){
        $sql = "SHOW TABLES LIKE 'boodschappenlijst'";
        $result = mysqli_query($this->connection, $sql);
        if ($result -> num_rows == 0) {
            # Creeren van een tabel als deze nog niet bestaat
            $sql_tabel = "CREATE TABLE boodschappenlijst (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            naam VARCHAR(225) NOT NULL,
            prijs_per_verpakking VARCHAR(225) NOT NULL,
            verpakking VARCHAR(225) NOT NULL,
            aantal VARCHAR(225) NOT NULL,
            ingredienten_nodig VARCHAR(225) NOT NULL,
            artikel_id INT NOT NULL, 
            user_id INT NOT NULL)";

            $result_table = mysqli_query($this->connection, $sql_tabel);
        }
    }


    private function ArtikelOpLijst($user_id, $artikel_id) {
        $lijst =  $this -> OphalenLijst($user_id);
        foreach ($lijst as $ingredient){
            if ($ingredient['artikel_id'] == $artikel_id) {
                return $ingredient;
                break;
            }
        }
        return FALSE;
    }


    private function addArticleToList($ingridient, $user_id){
        $naam =  $ingridient["naam"];
        $prijs_per_verpakking = (float)$ingridient["prijs"];
        $verpakking = (int)$ingridient["verpakking"];
        $aantal = (int)ceil($ingridient["aantal"] / $ingridient["verpakking"]);
        $ingredienten_nodig = (float)$ingridient["aantal"];
        $artikel_id = (float)$ingridient["artikel_id"];

        $sql = "INSERT INTO boodschappenlijst 
        (naam, prijs_per_verpakking, verpakking, aantal, ingredienten_nodig, user_id, artikel_id) 
        VALUES 
        ('$naam', $prijs_per_verpakking, $verpakking, $aantal, $ingredienten_nodig, $user_id, $artikel_id)";

        $result = mysqli_query($this->connection, $sql);
    }


    private function hoeveelheidIngredientUpdaten($ingridient, $user_id){
        $artikel_id = $ingridient['artikel_id'];
        $sql = "SELECT ingredienten_nodig FROM boodschappenlijst where artikel_id = '$artikel_id' AND user_id = '$user_id'";
        $result = mysqli_query($this->connection, $sql);
        $row = $result -> fetch_assoc(); 
        $row["ingredienten_nodig"] += (float)$ingridient["aantal"];

        $ingredienten_nodig = $row["ingredienten_nodig"];
        $sql_upd = "UPDATE boodschappenlijst SET ingredienten_nodig = '$ingredienten_nodig' WHERE artikel_id = '$artikel_id' AND user_id = '$user_id'";
        mysqli_query($this->connection, $sql_upd);
        return $ingredienten_nodig;
    }

    
    private function verpakkingUpdaten($artikel_id, $ingredienten_nodig, $user_id){
        # 1. De nodige informatie ophalen 
        $sql_oph = "SELECT aantal, verpakking FROM boodschappenlijst where artikel_id = '$artikel_id'  AND user_id = '$user_id'";                
        $result = mysqli_query($this->connection, $sql_oph);
        $row = $result -> fetch_assoc();
        echo "<br>";
                
        # 2. Kijken meer moeten bestellen
        if ($ingredienten_nodig > $row["aantal"] * $row["verpakking"]) {
            $aantal = ceil($ingredienten_nodig / $row["verpakking"]);
            $sql_upd = "UPDATE boodschappenlijst SET aantal = '$aantal' WHERE artikel_id = '$artikel_id'  AND user_id = '$user_id'";
            mysqli_query($this->connection, $sql_upd);
            }
    }

    
    public function OphalenLijst($user_id){
        $sql = "Select * FROM boodschappenlijst WHERE user_id = '$user_id'";
        $result = mysqli_query($this->connection, $sql);

        $list = [];
        while ($ingredient = $result->fetch_assoc()){
            $list[] = $ingredient;
        }
        return($list);
    }

    
    private function getIngredient($gerecht_id) {
        $ingData = $this -> ing -> selecteerIngredient($gerecht_id); 
        return($ingData);
    }

#########################################################################################
#                                                                                       #
#                                       Eerste versie                                   #
#                                                                                       #
#########################################################################################

    public function boodschappenToevoegen($gerecht_id, $user_id = 1) {
        # Checken of de tabel al bestaat
        $sql = "SHOW TABLES LIKE 'boodschappenlijst'";
        $result = mysqli_query($this->connection, $sql);
        if ($result -> num_rows == 0) {
            # Creeren van een tabel als deze nog niet bestaat
            $sql_tabel = "CREATE TABLE boodschappenlijst (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            naam VARCHAR(225) NOT NULL,
            prijs_per_verpakking VARCHAR(225) NOT NULL,
            verpakking VARCHAR(225) NOT NULL,
            aantal VARCHAR(225) NOT NULL,
            ingredienten_nodig VARCHAR(225) NOT NULL,
            artikel_id INT NOT NULL, 
            user_id INT NOT NULL)";

            $result_table = mysqli_query($this->connection, $sql_tabel);
        }

        # Ophalen ingredienten
        $ingridients =  $this -> getIngredient($gerecht_id);

        foreach ($ingridients as $ingridient) {
            # Data klaarmaken voor in de tabel
            $naam = $ingridient["naam"];

            # Checken of de ingredient al in de tabel staat
            $sql_check = "Select * FROM boodschappenlijst WHERE naam = '$naam' AND user_id = '$user_id'";
            $result_check = mysqli_query($this -> connection, $sql_check);

            if ($result_check -> num_rows == 0) {
                # Data in tabel zetten
                $prijs_per_verpakking = (float)$ingridient["prijs"];
                $verpakking = (int)$ingridient["verpakking"];
                $aantal = (int)ceil($ingridient["aantal"] / $ingridient["verpakking"]);
                $ingredienten_nodig = (float)$ingridient["aantal"];
                $artikel_id = (float)$ingridient["artikel_id"];

                $sql_ing = "INSERT INTO boodschappenlijst 
                (naam, prijs_per_verpakking, verpakking, aantal, ingredienten_nodig, user_id, artikel_id) 
                VALUES 
                ('$naam', $prijs_per_verpakking, $verpakking, $aantal, $ingredienten_nodig, $user_id, $artikel_id)";

                $result_ing = mysqli_query($this->connection, $sql_ing);
            } else {
                # 1. Eerdere hoeveelheid benodigde ingrediënt ophalen
                $sql_ing = "SELECT ingredienten_nodig FROM boodschappenlijst where naam = '$naam' AND user_id = '$user_id'";
                $result_ing = mysqli_query($this->connection, $sql_ing);
                $row_ing = $result_ing -> fetch_assoc(); 
                $ingredienten_nodig = $row_ing["ingredienten_nodig"];
                #var_dump($naam);
                #var_dump($ingredienten_nodig);

                # 2. Hoeveelheid aanpassen
                $ingredienten_nodig += (float)$ingridient["aantal"];
                #var_dump($naam);
                #var_dump($ingredienten_nodig);

                # 3. Aanpassen (werkt tot hier, nu verder testen)
                $sql_update_ing = "UPDATE boodschappenlijst SET ingredienten_nodig = '$ingredienten_nodig' WHERE naam = '$naam'  AND user_id = '$user_id'";
                $result_update_ing = mysqli_query($this->connection, $sql_update_ing);

                # 4. Checken of men meer verpakkingen moet kopen om alle ingredienten te hebben
                # 4.1 De nodige informatie ophalen
                $sql_aantalVerpakking = "SELECT aantal, verpakking FROM boodschappenlijst where naam = '$naam'  AND user_id = '$user_id'";                
                $result_aantalVerpakking = mysqli_query($this->connection, $sql_aantalVerpakking);
                $row_aantalVerpakking = $result_aantalVerpakking -> fetch_assoc();
                
                $aantal = $row_aantalVerpakking["aantal"];
                $verpakking = $row_aantalVerpakking["verpakking"];

                # 4.2 Kijken meer moeten bestellen
                if ($ingredienten_nodig > $aantal * $verpakking) {
                    $aantal = ceil($ingredienten_nodig / $verpakking);
                    $sql_update_aantal = "UPDATE boodschappenlijst SET aantal = '$aantal' WHERE naam = '$naam'  AND user_id = '$user_id'";
                    $result_update_aantal = mysqli_query($this->connection, $sql_update_aantal);
                }
            }
        }
    }
}

