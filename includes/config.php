<?php
ob_start(); // output buffering
session_start();

date_default_timezone_set("America/Toronto");

try {
    // $con = new PDO("mysql:dbname=grinfarm;host=localhost", "root", "");
    $con = new PDO("mysql:dbname=grindb;host=grinfarmdb.czpjrp5kwxpx.us-east-1.rds.amazonaws.com", "admin", "Grinfarm6^");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>