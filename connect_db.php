<?php
session_start();

$servername = "localhost"; 
$username = "postgres";
$password = "CPLAssets123";
$dbname = "asset_system";
$port = "5432";

try {
    $pdo = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>