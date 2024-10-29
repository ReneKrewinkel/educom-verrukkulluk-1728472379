<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/kt.php");
require_once("lib/ingredient.php");
require_once("lib/BFOW.php");
require_once("lib/recipe.php");
require_once("lib/boodschappenToevoegen.php");
require_once("lib/boodschappenToevoegenVolgensAlgoritme.php");
require_once("fase-2/lib/gerecht.php");

$db = new database();
$gerecht = new recipe($db -> getConnection());
$data = $gerecht -> selecteerRecipe();


#var_dump($test -> selecteerRecipe());

# $gerecht = new gerecht();
// var_dump($data);

/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["recipe_id"]) ? $_GET["recipe_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";
// $action = isset($_GET["action"]) ? $_GET["action"] : "detail";

switch($action) {

        case "homepage": {
            $data = $gerecht->selecteerRecipe();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $gerecht->selecteerRecipe($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
        break;
        }

        /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
# De eerste geeft de template weer, de tweede laat zien data data niet leeg is
# $Template heeft voorrang
echo $template->render(["title" => $title, "data" => $data]);
# print_r($data);