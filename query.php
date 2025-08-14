<?php 
require 'config.php';

$datum = date("Y-m-d");
$start = $_GET['start'];
$end = $_GET['end'];

if($start == "") {
    $start = $datum;
}

if($end == "") {
    $end = $datum;
}

try {
    $db = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $db->query("SET CHARACTER SET utf8");

    $sth = $db->query("SELECT gasprices.timestamp AS timestamp, stations.brand AS brand, stations.street AS street, stations.city AS city, gasprices.diesel AS diesel, gasprices.e5 AS e5, gasprices.e10 AS e10 FROM gasprices, stations WHERE SUBSTRING(timestamp, 1, 10) >= '".$start."' AND SUBSTRING(timestamp, 1, 10) <= '".$end."' AND gasprices.stationID = stations.uuid");

    $prices = $sth->fetchAll();
    
    echo json_encode( $prices );
} catch (Exception $e) {
    echo $e->getMessage();
}

?>