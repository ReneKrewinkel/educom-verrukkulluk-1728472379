<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

require_once "database2.php";

$db = new Database();
echo "<pre>";
var_dump($db->connection);
