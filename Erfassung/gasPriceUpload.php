<?php
// gasPriceUpload.php?id=005056ba-7cb6-1ed2-bceb-5113f4c1cd12&diesel=1.009&e5=1.209&e10=1.189

require './config.php';

$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB, USER, PASS);

$stationID = $_GET['id'];
$diesel = $_GET['diesel'];
$e5 = $_GET['e5'];
$e10 = $_GET['e10'];

$statement = $pdo->prepare("INSERT INTO gasprices (stationID, diesel, e5, e10) VALUES (?, ?, ?, ?)");
$statement->execute(array($stationID, $diesel, $e5, $e10));

?>