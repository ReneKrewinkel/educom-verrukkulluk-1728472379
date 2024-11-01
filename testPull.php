<?php
require_once("lib/database.php");

$db = new Database();
$conn = $db -> getConnection();

$sql = "SELECT AVG(aantalSterren) as averageRating FROM test_v1";
$result = $conn -> query($sql);

if ($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
    echo $row['averageRating'];
}

$conn -> close();
?>