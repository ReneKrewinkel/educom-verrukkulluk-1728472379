<?php 

// Aanpassen naar je eigen omgeving
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "verrukkulluk");
define("HOST", "localhost");

class Database {
    public $connection;

    public function __construct(){
        $this->connection = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die(mysqli_error($const));
    }

    public function getDataBase(){
        echo "<br> Get database function";
    }
}