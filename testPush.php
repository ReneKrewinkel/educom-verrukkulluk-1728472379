<?php
require_once("lib/database.php");

$db = new Database();
$conn = $db -> getConnection();

if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];
    $sql = "INSERT INTO test_v1 (aantalSterren) VALUES ('$rating')";
    $conn -> query($sql);
    exit;
}

$conn -> close();
?>