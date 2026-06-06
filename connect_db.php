<?php
session_start();

$servername = "localhost";
$port = "5432";
$username = "postgres";
$password = "CPLAssets123";
$dbname = "asset_system";

try {
    $pdo = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>