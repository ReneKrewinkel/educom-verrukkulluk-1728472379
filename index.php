<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kt.php");
require_once("lib/ingredient.php");
require_once("lib/BFOW.php");
require_once("lib/recipe.php");

/// INIT
$db = new database();
$rec = new recipe($db -> getConnection());

/// VERWERK 
$recData = $rec -> selecteerRecipe();


/// RETURN
var_dump($recData);