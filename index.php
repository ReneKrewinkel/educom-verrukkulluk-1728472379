<?php

require_once("lib/database.php");
#require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kt.php");
require_once("lib/ingredient.php");

/// INIT
$db = new database();
#$art = new artikel($db->getConnection());
$use = new user($db->getConnection());
$kt = new kitchenType($db->getConnection());
$ing = new ingredient($db->getConnection());

/// VERWERK 
#$artData = $art->selecteerArtikel(1);
$useData = $use->selecteerUser(5);
$ktData = $kt->selecteerKT(1);
$ingData = $ing->selecteerIngredient(2);

/// RETURN
#var_dump($artData);
echo "<br><br>";
#var_dump($useData);
echo "<br><br>";
#var_dump($ktData);
echo "<br><br>";
var_dump($ingData);