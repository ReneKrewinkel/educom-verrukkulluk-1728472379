<?php
#require_once("./vendor/autoload.php");
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kt.php");
require_once("lib/ingredient.php");
require_once("lib/BFOW.php");
require_once("lib/recipe.php");
require_once("lib/boodschappenToevoegen.php");
require_once("lib/boodschappenToevoegenVolgensAlgoritme.php");

/// INIT
// $db = new database();
// $test = new ingredient($db -> getConnection());
// $boo = new boodschappenToevoegen($db -> getConnection());
// $booAlg = new boodschappenToevoegenVolgensAlgoritme($db -> getConnection());
// $gerecht_new = new recipe($db -> getConnection());

/// VERWERK 
// $recData = $rec -> selecteerRecipe();
// $booToevAlg_F = $booAlg -> boodschappenToevoegen_metFuncties(2, 2);
// $booToevAlg = $booAlg -> ophalenLijst(1);
// $gerecht_new = new recipe($db -> getConnection());
// $gerecht = $gerecht_new -> selecteerRecipe();
//echo "<pre>";
//var_dump($gerecht);

/// var_dump(selecteerIngredient($test -> $gerecht_id));
/// RETURN